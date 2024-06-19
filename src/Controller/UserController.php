<?php
declare(strict_types=1);
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\UserServiceInterface;
use App\Service\ImageServiceInterface;
use App\Service\UserService;
use App\Service\ImageService;
use App\Service\Data\UserData;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractController
{
    private const DATE_TIME_FORMAT = "Y-m-d";
    private UserServiceInterface $userServiceInterface; 
    private ImageServiceInterface $imageServiceInterface; 


    public function __construct(UserService $userService, ImageService $imageService)
    {
        $this->userServiceInterface =  $userService;
        $this->imageServiceInterface =  $imageService;
    }
    public function showRegisterForm(): Response
    {
        return $this->render('user/register.html.twig');
    }
    public function registerUser(Request $request): Response
    {
        $fileName = $this->imageServiceInterface->saveImage($request->files->get('image'));

        $user = new UserData(
            null,
            $request->get('first_name'),
            $request->get('last_name'),
            empty($request->get('middle_name')) ? null : $request->get('middle_name'),
            $request->get('gender'),
            $this->userServiceInterface->parseDateTime($request->get('birth_date'), self::DATE_TIME_FORMAT),
            $request->get('email'),
            empty($request->get('phone')) ? null : $request->get('phone'),
            empty($fileName) ? null : $fileName,
        );

        
        $userId = $this->userServiceInterface->create($user);
        return $this->redirectToRoute('show_user', ['id' => $userId]);
    }
    public function viewUser(int $id): Response
    {
        $user = $this->userServiceInterface->find($id);
        return $this->render('user/info.html.twig', ['user' => $user]);    
    }

    public function viewAllUsers(): Response
    {
        $allUsers = $this->userServiceInterface->findAll();
        return $this->render('user/list.html.twig', ['users' => $allUsers]);
    }
    public function main(): Response
    {
        return $this->render('main.html.twig');
    }
    private function parseDate($dateString): ?string {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})$/', $dateString, $matches)) {
            return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        }
        return null;
    }
    public function updateUserRedirect(int $id): Response 
    {
        $user = $this->userServiceInterface->find($id);
        return $this->render('user/update.html.twig', ['user' => $user]);
    }
    public function updateUser(Request $request, int $id)
    {
        if (!empty(($request->files->get('image')))) 
        {
            $fileName = $this->imageServiceInterface->saveImage($request->files->get('image'));
        } else {
            $fileName = null;
        }
        $user = new UserData(
            null,
            $request->get('first_name'),
            $request->get('last_name'),
            empty($request->get('middle_name')) ? null : $request->get('middle_name'),
            $request->get('gender'),
            $this->userServiceInterface->parseDateTime($request->get('birth_date'), self::DATE_TIME_FORMAT),
            $request->get('email'),
            empty($request->get('phone')) ? null : $request->get('phone'),
            empty($fileName) ? null : $fileName,
        );
        
        $this->userServiceInterface->updateInfo($user);
        return $this->redirectToRoute('show_user', ['id' => $id]);
    }
    public function deleteUser(int $id): Response
    {
        $id = $this->userServiceInterface->find($id)->getId();
        $this->userServiceInterface->delete($id);
        return $this->redirectToRoute('show_all_users');
    }
}