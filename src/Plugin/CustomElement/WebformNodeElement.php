<?php

namespace Drupal\site_studio_webform\Plugin\CustomElement;

use Drupal\cohesion_elements\CustomElementPluginBase;

/**
 * Site Studio element to help embedding a webform on a page.
 *
 * @package Drupal\site_studio_webform\Plugin\CustomElement
 *
 * @CustomElement(
 *   id = "site_studio_webform_node_element",
 *   label = @Translation("Webform Node Element")
 * )
 */
class WebformNodeElement extends CustomElementPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFields() {
    return [
      'webform_node_id' => [
        'title' => 'Webform node ID',
        'type' => 'textfield',
        'placeholder' => 'e.g. 256',
        'required' => TRUE,
        'validationMessage' => 'This field is required.',
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($element_settings, $element_markup, $element_class) {
    // Load the webform node.
    $webform_node = \Drupal::entityTypeManager()
      ->getStorage($element_settings['webform_node_id']['entity']['#entityType'])
      ->load($element_settings['webform_node_id']['entity']['#entityId']);

    // Get the webform field from the node and prepare for display.
    $webform = $webform_node->webform->view('full');

    // Render the element.
    return [
      '#theme' => 'site_studio_webform_node_element_template',
      '#elementSettings' => $element_settings,
      '#elementMarkup' => $element_markup,
      '#elementClass' => $element_class,
      '#webform' => $webform,
    ];
  }

}
