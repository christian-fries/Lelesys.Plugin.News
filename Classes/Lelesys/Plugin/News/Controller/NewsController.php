<?php

namespace Lelesys\Plugin\News\Controller;

/* *
 * This script belongs to the package "Lelesys.Plugin.News".               *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Mvc\Controller\ActionController;
use \Lelesys\Plugin\News\Domain\Model\News;

/**
 * News controller for the Lelesys.Plugin.News package
 *
 * @Flow\Scope("singleton")
 */
class NewsController extends AbstractNewsController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\NewsService
	 */
	protected $newsService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\CategoryService
	 */
	protected $categoryService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\TagService
	 */
	protected $tagService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 */
	protected $propertyMapper;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\AssetService
	 */
	protected $assetService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\FileService
	 */
	protected $fileService;

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\News\Domain\Service\LinkService
	 */
	protected $linkService;

	/**
	 * Shows a list of news
	 *
	 * @return void
	 */
	public function indexAction() {
		$allNews = $this->newsService->listAll();
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
	}

	/**
	 * Shows a list of news
	 *
	 * @return void
	 */
	public function latestNewsAction() {
		$allNews = $this->newsService->latestNews();
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
	}

	/**
	 * Shows a list of news for admin
	 *
	 * @param integer $recordLimit
	 * @return void
	 */
	public function adminListAction($recordLimit = NULL) {
		if ($recordLimit == NULL) {
			$recordLimit = $this->settings['newsPerPageAdmin'];
		}
		$this->view->assign('recordLimit', $recordLimit);
		$allNews = $this->newsService->adminNewsList();
		$this->view->assign('allNews', $allNews);
		$this->view->assign('assetsForNews', $this->newsService->assetsForNews($allNews));
	}

	/**
	 * Shows a single news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to show
	 * @return void
	 */
	public function showAction(\Lelesys\Plugin\News\Domain\Model\News $news = NULL) {
		if ($news !== NULL) {
			$related = $this->newsService->related($news);
			$argumentNamespace = $this->request->getArgumentNamespace();
			$this->view->assign('argumentNamespace', $argumentNamespace);
			$this->view->assign('assets', $related['assets']);
			$this->view->assign('comments', $related['comments']);
			$this->view->assign('relatedFiles', $related['files']);
			$this->view->assign('relatedLinkData', $this->newsService->show($news));
			$this->view->assign('relatedNews', $related['news']);
			$this->view->assign('categories', $related['categories']);
			$this->view->assign('tags', $news->getTags());
			$this->view->assign('news', $news);
		}
	}

	/**
	 * Shows a form for creating a new news object
	 *
	 * @return void
	 */
	public function newAction() {
		$this->view->assign('related', $this->newsService->listAll());
		$this->view->assign('newsCategories', $this->categoryService->listAll());
		$this->view->assign('tags', $this->tagService->listAll());
	}

	/**
	 * Set property mapper news creation
	 *
	 * @return void
	 */
	public function initializeCreateAction() {
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('dateTime')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['newNews']->getPropertyMappingConfiguration()->forProperty('archiveDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
	}

	/**
	 * Adds the given new news object to the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $newNews A new news to add
	 * @param array $media
	 * @param array $file
	 * @param array $relatedLink
	 * @return void
	 */
	public function createAction(\Lelesys\Plugin\News\Domain\Model\News $newNews, $media, $file, $relatedLink) {
		try {
			$this->newsService->create($newNews, $media, $file, $relatedLink);
			$this->addFlashMessage('Created a new news.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot create news at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Shows a form for editing an existing news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to edit
	 * @return void
	 */
	public function editAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		$this->view->assign('relatedNews', $this->newsService->listRelatedNews($news));
		$this->view->assign('newsCategories', $this->categoryService->listAll());
		$this->view->assign('tags', $this->tagService->listAll());
		$this->view->assign('news', $news);
		$this->view->assign('media', $news->getAssets());
		$this->view->assign('files', $news->getFiles());
		$this->view->assign('relatedLinks', $news->getRelatedLinks());
	}

	/**
	 * Set property mapper news creation
	 *
	 * @return void
	 */
	public function initializeUpdateAction() {
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('dateTime')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
		$this->arguments['news']->getPropertyMappingConfiguration()->forProperty('archiveDate')
				->setTypeConverterOption(
						'TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'm/d/Y'
		);
	}

	/**
	 * Updates the given news object
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to update
	 * @param array $media
	 * @param array $file
	 * @param array $relatedLink
	 * @return void
	 */
	public function updateAction(\Lelesys\Plugin\News\Domain\Model\News $news, $media, $file, $relatedLink) {
		try {
			$this->newsService->update($news, $media, $file, $relatedLink);
			$this->addFlashMessage('Updated the news.', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Cannot update news at this time!!.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the given news object from the news repository
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news The news to delete
	 * @return void
	 */
	public function deleteAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->delete($news);
			$this->addFlashMessage('Deleted a news.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param string $assetId
	 * @return void
	 */
	public function removeAssetAction($newsId, $assetId) {
		try {
			$asset = $this->assetService->findById($assetId);
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeAsset($asset, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param string $linkId
	 * @return void
	 */
	public function removeRelatedLinkAction($newsId, $linkId) {
		try {
			$link = $this->linkService->findById($linkId);
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeRelatedLink($link, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Removes the asset of news
	 *
	 * @param string $newsId
	 * @param string $fileId
	 * @return void
	 */
	public function removeRelatedFileAction($newsId, $fileId) {
		try {
			$file = $this->fileService->findById($fileId);
			$news = $this->newsService->findById($newsId);
			$this->newsService->removeRelatedFile($file, $news);
			echo json_encode(1);
			exit;
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * hide's the news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function hideNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->hideNews($news);
			$this->addFlashMessage('News is Hidden', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * show's the hidden news
	 *
	 * @param \Lelesys\Plugin\News\Domain\Model\News $news
	 * @return void
	 */
	public function showNewsAction(\Lelesys\Plugin\News\Domain\Model\News $news) {
		try {
			$this->newsService->showNews($news);
			$this->addFlashMessage('News is Visible', '', \TYPO3\Flow\Error\Message::SEVERITY_OK);
			$this->redirect('adminList');
		} catch (Lelesys\Plugin\News\Domain\Service\Exception $exception) {
			$this->addFlashMessage('Sorry, error occured. Please try again later.', '', \TYPO3\Flow\Error\Message::SEVERITY_ERROR);
		}
	}

	/**
	 * Searches news by title
	 *
	 * @param string $search
	 * @return void
	 */
	public function searchNewsAction($search = NULL) {
		$this->view->assign('newsSearched', $this->newsService->searchResult($search));
	}

	/**
	 * Shows Archive Date menu
	 *
	 * @return void
	 */
	public function archiveAction() {
		$this->view->assign('archiveView', $this->newsService->archiveDateView());
	}

	/**
	 * Shows list of news as per month
	 *
	 * @param integer $year
	 * @param string $month
	 * @return void
	 */
	public function showArchiveNewsAction($year, $month) {
		$this->view->assign('archiveNewsList', $this->newsService->archiveNewsList($year, $month));
	}

	/**
	 * Downloads the file
	 *
	 * @param array $file
	 * @return void
	 */
	public function downloadFileAction(array $file) {
		$this->newsService->downloadFile($file);
	}

}

?>