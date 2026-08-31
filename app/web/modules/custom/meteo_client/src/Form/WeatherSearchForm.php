<?php

namespace Drupal\meteo_client\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Lets the user look up today's forecast for a place by name.
 */
class WeatherSearchForm extends FormBase
{

  public function getFormId(): string
  {
    return 'meteo_client_weather_search_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#required' => TRUE,
      '#size' => 30,
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Get forecast'),
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state): void
  {
    $place = strtolower(trim($form_state->getValue('city')));
    $form_state->setRedirect('meteo_client.today', ['place' => $place]);
  }

}
