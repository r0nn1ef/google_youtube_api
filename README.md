# Google YouTube API
   
 * Introduction
 * Requirements
 * Installation
 * Configuration
 * Usage
 * Troubleshooting
 * Maintainers
 
## Introduction

The Google YouTube API module is an API-only module and does nothing on it's own. The module allows other contributed or
custom modules to communicate with YouTube using the YouTube v3 API using existing functionality in the official 
[Google PHP API client library](https://github.com/googleapis/google-api-php-client).

## Requirements

Google YouTube API is built upon the [Google API Client](https://www.drupal.org/project/google_api_client) module which
is required to be before this module will function.

## Installation

Install the module following the standard [Drupal 8 module installation](https://www.drupal.org/docs/8/extending-drupal-8/installing-drupal-8-modules)
guide on [Drupal.org](https://www.drupal.org).

## Configuration

Configure the Google API PHP Client with the following scopes (minimum):

* https://www.googleapis.com/auth/youtube
* https://www.googleapis.com/auth/youtube.upload
* https://www.googleapis.com/auth/youtube.force-ssl
* https://www.googleapis.com/auth/youtubepartner

## Usage

Using the Google YouTube API is relatively straight forward. Below demonstrates how to retrieve a video object using the
API.

```php
$video = NULL;
$GoogleYoutubeService = \Drupal::service('google_youtube_api.client');
  try {
    $videos = $GoogleYoutubeService->googleServiceYouTube->videos->listVideos('snippet', ['id' => $id]);
    if( count($videos->items) > 0 ) {
      $video = array_shift( $videos->items );
    }
  }
  catch (Exception $e) {
    \Drupal::logger('module_name')->error( $e->getMessage() );
    \Drupal::messenger()->addError( $e->getMessage() );
  }
```

See [https://developers.google.com/identity/protocols/googlescopes#youtubev3](https://developers.google.com/identity/protocols/googlescopes#youtubev3) for
available scopes.

## Troubleshooting

* First, ensure that the Google API client module has the appropriate settings and scopes.
* Consult the Google PHP API Library documentation for methods and parameters for working with videos and other YouTube content.

## Maintainers

* Ron Ferguson ([r0nn1ef](https://www.drupal.org/u/r0nn1ef))