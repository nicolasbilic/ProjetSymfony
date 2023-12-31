<?php

namespace App\Repository;

use App\Entity\Order;
use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Float_;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    /**
     * @return Order[] Returns an array of Order objects
     */
    public function findByExampleField($value): array
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findOneBySomeField($value): ?Order
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findTotalSales()
    {
        return $this->createQueryBuilder('o')
            ->select('SUM(o.total) as totalSales')
            ->getQuery()
            ->getResult()[0]['totalSales'];
    }

    public function findNumberOfOrders(): Int
    {
        return $this->createQueryBuilder('o')
            ->select('COUNT(o) as NbOrders')
            ->getQuery()
            ->getResult()[0]['NbOrders'];
    }

    public function getBestSales()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ol.product_name, SUM(ol.quantity) AS totalSales
            FROM App\Entity\OrderLine ol
            GROUP BY ol.product_name
            ORDER BY totalSales DESC'
        );
        $query->setMaxResults(6);
        $bestSales = $query->getResult();

        // Fetch details for each product
        foreach ($bestSales as &$sale) {
            $productName = $sale['product_name'];
            $productRepository = $entityManager->getRepository(Product::class);

            // Fetch the product entity based on product_name
            $product = $productRepository->findOneBy(['name' => $productName]);

            // Merge the details into the result
            $sale['product'] = $product;
        }

        return $bestSales;
    }
}
