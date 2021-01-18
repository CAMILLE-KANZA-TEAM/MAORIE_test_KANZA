<?php
namespace App\Services\Validators;

use App\Entity\CountVisiteurs;
use Psr\Log\LoggerInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Cache\Simple\FilesystemCache;
use Symfony\Component\Filesystem\Filesystem;
use App\Entity\GroupeChat;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Mime\Test\Constraint\EmailAddressContains;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\EmailValidator;
use Symfony\Component\Validator\Constraints\IsNull;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ValidatorBuilder;

class CheckFields
{

    private $_validator;

    private $_entityManager;

    const EMPTY_VALUE = "L'adresse email est vide";

    const MESSAGE_USER_EXIST = "L'adresse email existe déjà! Veuillez en choisir une autre.";

    const MESSAGE_USERNAME_EXIST = "Le pseudo choisi existe déjà! Veuillez en choisir un autre.";

    const MESSAGE_PASSWORD_EMPTY = "Le mot de passe est vide.";

    const MESSAGE_PROFIL_EMPTY = "Le type de profil est vide";


    public function __construct(ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $this->_validator = $validator;
        $this->_entityManager = $entityManager;
    }


    public function isValidEntity(User $userEntity) {

        $return = [
          'totalErrors' => 0,
          'errors'       => []
        ];

        $validatorsList = [
            ['field' => $userEntity->getEmail(),    'constraint' => new Email()],
            ['field' => $userEntity->getEmail(),    'constraint' => new NotNull(['message' => self::EMPTY_VALUE])],
            ['field' => $userEntity->getPassword(), 'constraint' => new NotNull(['message' => self::MESSAGE_PASSWORD_EMPTY])],
            ['field' => $userEntity,                'constraint' => new UniqueEntity(['fields' => ['email'],    'message' => self::MESSAGE_USER_EXIST])],
            ['field' => $userEntity,                'constraint' => new UniqueEntity(['fields' => ['username'], 'message' => self::MESSAGE_USERNAME_EXIST])],
        ];

        foreach ($validatorsList as $params) {
            $validatorError = $this->_addConstraint($params['field'], $params['constraint']);
            if ( $validatorError ) {
                $return['totalErrors'] += 1;
                $return['errors'][] =  $validatorError;
            }
        }
        return $return;
    }

    private function _addConstraint($fieldToCheck, $contraintInstance)
    {
        $validate = $this->_validator->validate($fieldToCheck,$contraintInstance);
        if ( $validate->count() > 0 ) {
            return $validate->get(0)->getMessage();
        }
        return null;
    }


}

