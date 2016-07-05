<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use NewsBundle\Services\UserService;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class RestController extends FosRestController
{
    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Get User info for given id",
     *   statusCodes = {
     *     302 = "Returned when successful",
     *     404 = "Returned when user with given id don't exists",
     *   }
     * )
     *
     */
    public function getUserAction($id)
    {
        $userRepository = $this->get('user.user_repository');
        $user = $userRepository->findOneById($id);
        if ($user !== null) {
            $view = $this->view([$user], Response::HTTP_OK);
        } else {
            $view = $this->view(
                ['message' => 'User with id: '.$id.' has been not found'],
                Response::HTTP_NOT_FOUND
            );
        }
        
        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Change authorized (current) User password",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     304 = "Returned when user pass has been not changed",
     *   }
     * )
     *
     * @RequestParam(name="old_pass", nullable=false, description="old password")
     * @RequestParam(name="new_pass", nullable=false, description="old password")
     */
    public function postUserChangePassAction(ParamFetcher $paramFetcher)
    {
        $currentUser = $this->getUser();
        $newPassword = $paramFetcher->get('new_pass');
        $oldPassword = $paramFetcher->get('old_pass');

        $userService = $this->get('user.user_service');
        if (
            $oldPassword !== $newPassword &&
            $userService->isPasswordCorrect($currentUser, $oldPassword)
        ) {
            $userService->updatePassword($currentUser, $newPassword);

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $view = $this->view(['message' => 'Password has been changed.'], Response::HTTP_OK);

        } else {
            $view = $this->view(['message' => 'Password has not been changed.'], Response::HTTP_NOT_MODIFIED);
        }

        return $this->handleView($view);
    }

    /**
     * @ApiDoc(
     *   resource = true,
     *   description = "Change authorized (current) User email",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     304 = "Returned when user email has been not changed",
     *   }
     * )
     * @RequestParam(name="new_email", nullable=false, description="new email")
     */
    public function postUserChangeEmailAction(ParamFetcher $paramFetcher)
    {
        $currentUser = $this->getUser();
        $email = $paramFetcher->get('new_email');

        if ($email !== $currentUser->getEmail()) {
            $currentUser->setEmail($email);
            $view = $this->view(['message' => 'Email has been changed.'], Response::HTTP_OK);
        } else {
            $view = $this->view(['message' => 'Email has not been changed.'], Response::HTTP_NOT_MODIFIED);
        }

        return $this->handleView($view);
    }
}
