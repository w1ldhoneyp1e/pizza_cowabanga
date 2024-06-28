<?php
declare(strict_types=1);
namespace App\Controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Service\UserServiceInterface;
use App\Service\ImageServiceInterface;
use App\Service\ProductServiceInterface;

use App\Service\UserService;
use App\Service\ImageService;
use App\Service\ProductService;

use App\Service\Data\UserData;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class UserController extends AbstractController
{
    private const DATE_TIME_FORMAT = "Y-m-d";
    private UserServiceInterface $userServiceInterface; 
    private ImageServiceInterface $imageServiceInterface; 
    private ProductServiceInterface $productServiceInterface;


    public function __construct(UserService $userService, ImageService $imageService, ProductService $productService)
    {
        $this->userServiceInterface =  $userService;
        $this->imageServiceInterface =  $imageService;
        $this->productServiceInterface = $productService;
    }
    public function showRegisterPage(): Response
    {
        return $this->render('user/register2.html.twig');
    }
    public function showLoginPage(): Response {
        return $this->render('user/login.html.twig');
    }
    public function showAdminPage(): Response
    {
        return $this->render('products/admin.html.twig');
    }
    public function registerUser(Request $request): Response
    {
        $requestArray = json_decode($request->getContent(), true);
        var_dump($requestArray);
        $user = new UserData(
            null,
            $requestArray['email'],
            $requestArray['password'],
            null,
            null,
            null,
            null,
            null
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

    private function parseDate($dateString): ?string {
        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})$/', $dateString, $matches)) {
            return $matches[1] . '-' . $matches[2] . '-' . $matches[3];
        }
        return null;
    }
    public function showUpdateUser(int $id): Response 
    {
        $user = $this->userServiceInterface->find($id);
        return $this->render('user/update.html.twig', ['user' => $user]);
    }
    public function updateUser(Request $request, int $id)
    {
        $requestArray = json_decode($request->getContent(), true);
        if (!empty(($request->files->get('image')))) 
        {
            $fileName = $this->imageServiceInterface->saveImageAsBase64($requestArray['avatar']);
        } else {
            $fileName = null;
        }
        $user = new UserData(
            $id,
            $requestArray['email'],
            empty($requestArray['password']) ? null : $requestArray['password'],
            empty($requestArray['firstName']) ? null : $requestArray['firstName'],
            empty($requestArray['lastName']) ? null : $requestArray['lastName'],
            empty($requestArray['phone']) ? null : $requestArray['phone'],
            empty($requestArray['adress']) ? null : $requestArray['adress'],
            empty($fileName) ? null : $fileName,
        );
        $this->userServiceInterface->updateInfo($user);
        return $this->redirectToRoute('show_user', ['id' => $id]);
    }
    public function deleteUser(int $id): Response
    {
        $this->userServiceInterface->delete($id);
        return $this->redirectToRoute('index');
    }
    
}