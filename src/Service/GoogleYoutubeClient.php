<?php

namespace Drupal\google_youtube_api\Service;

use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Logger\LoggerChannelFactoryInterface;
use Drupal\google_api_client\Service\GoogleApiClient;

/**
 * Class GoogleYoutubeClient.
 */
class GoogleYoutubeClient {

  /**
   * The logger factory.
   *
   * @var \Drupal\Core\Logger\LoggerChannelFactoryInterface
   */
  public $loggerFactory;

  /**
   * Uneditable Config.
   *
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  private $config;

  /**
   * Uneditable Tokens Config.
   *
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  private $configTokens;

  /**
   * Google API Client.
   *
   * @var \Drupal\google_api_client\Service\GoogleApiClient
   */
  private $googleApiClient;

  /**
   * Google Service Photos Library.
   *
   * @var \Google_Service_YouTube
   */
  public $googleServiceYouTube;

  /**
   * Callback Controller constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactory $config
   *   An instance of ConfigFactory.
   * @param \Drupal\Core\Logger\LoggerChannelFactoryInterface $loggerFactory
   *   LoggerChannelFactoryInterface.
   * @param \Drupal\google_api_client\Service\GoogleApiClient $googleApiClient
   *   GoogleApiClient.
   */
  public function __construct(ConfigFactory $config,
                              LoggerChannelFactoryInterface $loggerFactory,
                              GoogleApiClient $googleApiClient) {
    $this->config = $config->get('google_api_client.settings');
    $this->configTokens = $config->get('google_api_client.tokens');
    $this->loggerFactory = $loggerFactory;

    $this->googleApiClient = $googleApiClient;
    $this->googleServiceYouTube = $this->getGoogleServiceYoutube();
  }

  /**
   * Helper method to getGoogleYoutubeClient.
   *
   * @return \Google_Service_YouTube
   *   Google Service YouTube.
   */
  private function getGoogleServiceYoutube() {
    $this->googleApiClient->googleClient->setScopes(["https://www.googleapis.com/auth/youtube", "https://www.googleapis.com/auth/youtubepartner", "https://www.googleapis.com/auth/youtube.upload"]);

    // Set up the YouTube Client that interacts with the API.
    $googleServicePhotosLibrary = new \Google_Service_YouTube($this->googleApiClient->googleClient);
    return $googleServicePhotosLibrary;
  }

}
