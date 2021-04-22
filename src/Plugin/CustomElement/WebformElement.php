<?php

namespace Drupal\site_studio_webform\Plugin\CustomElement;

use Drupal\cohesion_elements\CustomElementPluginBase;

/**
 * Site Studio element to help embedding a webform on a page.
 *
 * @package Drupal\site_studio_webform\Plugin\CustomElement
 *
 * @CustomElement(
 *   id = "site_studio_webform_element",
 *   label = @Translation("Webform Element")
 * )
 */
class WebformElement extends CustomElementPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFields() {
    $options = \Drupal::entityQuery('webform')
      ->execute();

    return [
      'webform_id' => [
        'title' => 'Webform node ID',
        'type' => 'select',
        'nullOption' => FALSE,
        'options' => $options,
        'required' => TRUE,
        'validationMessage' => 'This field is required.',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($element_settings, $element_markup, $element_class) {
    if (empty($element_settings['webform_id'])) {
      return;
    }
    // Load the webform node.
    $webform = \Drupal::entityTypeManager()
      ->getStorage('webform')
      ->load($element_settings['webform_id']);

    // Get the webform field from the node and prepare for display.
    $webform_render = \Drupal::entityTypeManager()
      ->getViewBuilder('webform')
      ->view($webform);

    // Render the element.
    return [
      '#theme' => 'site_studio_webform_element_template',
      '#elementSettings' => $element_settings,
      '#elementMarkup' => $element_markup,
      '#elementClass' => $element_class,
      '#webform' => $webform_render,
    ];
  }

}
