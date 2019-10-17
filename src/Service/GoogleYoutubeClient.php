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
   * Wrapper for \Google_Service_YouTube_Resource_Videos::listVideos().
   *
   * @param mixed array|strinng $parts
   * @param $optParams
   *
   * @return mixed
   */
  public function listVideos($parts, $optParams) {
    if (is_array($parts)) {
      $parts = implode(',', $parts);
    }
    return $this->googleServiceYouTube->videos->listVideos($parts, $optParams);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::update().
   *
   * @param mixed array|string $parts
   * @param \Google_Service_YouTube_Video $video
   *
   * @return mixed
   */
  public function updateVideo($parts, \Google_Service_YouTube_Video $video) {
    if (is_array($parts)) {
      $parts = implode(',', $parts);
    }
    return $this->googleServiceYouTube->videos->update($parts, $video);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::delete().
   *
   * @param string $id
   * @param array $optParams
   *
   * @return mixed
   */
  public function delete($id, $optParams = []) {
    return $this->googleServiceYouTube->videos->delete($id, $optParams);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::insert().
   *
   * @param $part
   * @param \Google_Service_YouTube_Video $postBody
   * @param array $optParams
   *
   * @return mixed
   */
  public function insert($part, \Google_Service_YouTube_Video $postBody, $optParams = []) {
    return $this->googleServiceYouTube->videos->insert($part, $postBody, $optParams);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::rate().
   *
   * @param $id
   * @param $rating
   * @param array $optParams
   *
   * @return mixed
   */
  public function rate($id, $rating, $optParams = []) {
    return $this->googleServiceYouTube->videos->rate($id, $rating, $optParams);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::getRating().
   *
   * @param $id
   * @param array $optParams
   *
   * @return mixed
   */
  public function getRating($id, $optParams = []) {
    return $this->googleServiceYouTube->videos->getRating($id, $optParams);
  }

  /**
   * Wrapper for \Google_Service_YouTube_Resource_Videos::reportAbuse().
   *
   * @param \Google_Service_YouTube_VideoAbuseReport $postBody
   * @param array $optParams
   *
   * @return mixed
   */
  public function reportAbuse(\Google_Service_YouTube_VideoAbuseReport $postBody, $optParams = []) {
    return $this->googleServiceYouTube->videos->reportAbuse($postBody, $optParams);
  }

  /**
   * Helper method to getGoogleYoutubeClient.
   *
   * @return \Google_Service_YouTube
   *   Google Service YouTube.
   */
  private function getGoogleServiceYoutube() {
    $this->googleApiClient->googleClient->setScopes([
      "https://www.googleapis.com/auth/youtube",
      "https://www.googleapis.com/auth/youtubepartner",
      "https://www.googleapis.com/auth/youtube.upload",
      "https://www.googleapis.com/auth/youtube.force-ssl",
    ]);

    // Set up the YouTube Client that interacts with the API.
    $googleServiceYoutube = new \Google_Service_YouTube($this->googleApiClient->googleClient);
    return $googleServiceYoutube;
  }

}
