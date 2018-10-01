<?php

namespace AppBundle\Repository;
use Doctrine\ORM\EntityRepository;

class AbcMemberRepository extends EntityRepository
{
    /* Encuentra los usuarios existentes
    */
    public function findAllUsers()
    {
        $dql = 'SELECT m, l, r FROM AppBundle:Member m '
            .'JOIN m.login l '
            .'JOIN l.role r '
            ."WHERE r.name= 'ROLE_ADMIN' "
            .'ORDER BY m.createdDate';
        $repositorio = $this->getEntityManager()->createQuery($dql);

        return $repositorio->getResult();
    }

    /* Encuentra un usuario por el memberIb
    */
    public function findOneUser($memberId)
    {
        $dql = 'SELECT m, l, r FROM AppBundle:Member m '
            .'JOIN m.login l '
            .'JOIN l.role r '
            ."WHERE r.name= 'ROLE_ADMIN' AND m.id=$memberId "
            .'ORDER BY m.createdDate';
        $repositorio = $this->getEntityManager()->createQuery($dql);

        return $repositorio->getResult();
    }
}