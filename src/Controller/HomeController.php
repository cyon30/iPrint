<?php

namespace App\Controller;

use App\Entity\Item;
use App\Entity\ItemPrint;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private array $SORT_LIST = [
        'id' => 'ASC',
        'code' => 'ASC',
        'description' => 'ASC',
        'bin' => 'ASC',
        'bar' => 'ASC'
    ];

    #[Route(path: '/', name: 'home-page')]
    #[Template('home.html.twig')]
    public function homeAction(): array
    {
        return [];
    }

    #[Route(path: '/search', name: 'search-page', methods: "GET")]
    #[Template('search.html.twig')]
    public function searchAction(EntityManagerInterface $entityManager, Request $request): array
    {
        /** @var ItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository(Item::class);

        /** @var Item[] $item */
        if (null !== $request->get('q') && !empty($request->get('q'))) {
            $items = $itemRepository->findBySearchString($request->get('q'), $this->generateSort($request));
        } else {
            $items = $itemRepository->findBy([], $this->generateSort($request), 20);
        }

        return [
            'items' => $items,
            'sort' => $this->SORT_LIST
        ];
    }

    #[Route(path: '/print', name: 'print-page')]
    #[Template('print.html.twig')]
    public function printAction(EntityManagerInterface $entityManager, Request $request): array
    {
        /** @var ItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository(Item::class);

        $item = null;
        if (null !== $request->get('id')) {
            $item = $itemRepository->find($request->get('id'));
        }

        return [
            'item' => $item
        ];
    }

    #[Route(path: '/barcode-print/{id}', name: 'barcode-print-page')]
    #[Template('barcodePrint.html.twig')]
    public function barcodePrintAction(EntityManagerInterface $entityManager, Request $request): array
    {
        /** @var ItemRepository $itemRepository */
        $itemRepository = $entityManager->getRepository(Item::class);

        $item = null;
        if (null !== $request->get('id')) {
            /** @var Item $item */
            $item = $itemRepository->find($request->get('id'));
        }

        $itemPrint = new ItemPrint();
        $itemPrint->setItem($item);
        $entityManager->persist($itemPrint);

        $item->addPrint($itemPrint);
        $entityManager->flush();

        return [
            'item' => $item
        ];
    }

    private function generateSort(Request $request): array
    {
        if (null === $request->get('s') || !array_key_exists($request->get('s'), $this->SORT_LIST)) {
            return [];
        }

        $this->SORT_LIST[$request->get('s')] = ($request->get('d') === 'ASC') ? 'DESC' : 'ASC';
        return [$request->get('s') => $this->SORT_LIST[$request->get('s')]];
    }
}