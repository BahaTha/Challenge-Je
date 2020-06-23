<?php

namespace App\Repository;

use App\Entity\User5;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @method User5|null find($id, $lockMode = null, $lockVersion = null)
 * @method User5|null findOneBy(array $criteria, array $orderBy = null)
 * @method User5[]    findAll()
 * @method User5[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class User5Repository extends ServiceEntityRepository implements PasswordUpgraderInterface
{ private $encryptionService;
    private $entityManager;
    private $userPasswordEncoderInterface;
 
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User5::class);
    }
    public function save(User5 $user): Response
    {
        $passwordHash = $this->userPasswordEncoderInterface->encodePassword($user, $user->getPassword());
        $user->setPassword($passwordHash);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return new Response('password encoded');
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User5) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }
    public function loadUserByUsername($usernameOrEmail)
    {
        return $this->createQuery(
                'SELECT u
                FROM App\Entity\User5 u
                WHERE u.username = :query
                OR u.email = :query'
            )
            ->setParameter('query', $usernameOrEmail)
            ->getQuery()
            ->getOneOrNullResult();
    }

     /**
      * @return User5[] Returns an array of User5 objects
      */
    
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    

    
    public function findOneBySomeField($value): ?User5
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
