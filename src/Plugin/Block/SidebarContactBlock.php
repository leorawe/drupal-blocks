<?php

namespace Drupal\lwblocks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides an contact block for sidebar.
 *
 * @Block(
 *   id = "lwblocks_contactblock",
 *   admin_label = @Translation("Contact Block"),
 *   category = @Translation("lwblocks")
 * )
 */

class SidebarContactBlock extends BlockBase implements BlockPluginInterface {
    /**
     * {@inheritdoc}
     */
    public function blockForm($form, FormStateInterface $form_state) {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();
        $form['name'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#default_value' => isset($config['name']) ? $config['name'] : '',
        ];
        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#default_value' => isset($config['email']) ? $config['email'] : '',
        ];
        $form['programlink'] = [
            '#type' => 'linkit',
            '#title' => $this->t('Program Link'),
            '#description' => $this->t('Start typing to see a list of results. Click to select.'),
            '#autocomplete_route_name' => 'linkit.autocomplete',
            '#autocomplete_route_parameters' => [
              'linkit_profile_id' => 'mylinkit',
            ],
            '#default_value' => isset($config['programlink']) ? $config['programlink'] : '',
        ];
        $form['programtext'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Program Name'),
            '#default_value' => isset($config['programtext']) ? $config['programtext'] : '',
        ];

        return $form;
    }
    public function blockSubmit($form, FormStateInterface $form_state) {
        $this->setConfigurationValue('name', $form_state->getValue('name'));
        $this->setConfigurationValue('programlink', $form_state->getValue('programlink'));
        $this->setConfigurationValue('programtext', $form_state->getValue('programtext'));
        $this->setConfigurationValue('email', $form_state->getValue('email'));
    }
    public function build() {
        $config = $this->getConfiguration();
        if (!empty($config['name'])) {
            $res['name'] = $config['name'];
        }
        if (!empty($config['programlink'])) {
            $res['programlink'] = $config['programlink'];
        }
        if (!empty($config['programtext'])) {
            $res['programtext'] = $config['programtext'];
        }
        if (!empty($config['email'])) {
            $res['email'] = $config['email'];
        }
        return [
            '#theme' => 'sidebar-contact-block',
            '#result' => $res
        ];

    }

}
