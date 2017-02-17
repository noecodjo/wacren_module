<?php
/**
@file
Contains \Drupal\wacren_bandwith\Controller\AdminController.
 */

namespace Drupal\wacren_bandwith\Controller;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\wacren_bandwith\BdContactStorage;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Template\TwigEnvironment;


class AdminController extends ControllerBase {

function contentOriginal() {
  $url = Url::fromRoute('wacren_bandwith_add');
  //$add_link = ;
  $add_link = '<p>' . \Drupal::l(t('New message'), $url) . '</p>';

  // Table header
  $header = array( 'id' => t('Id'), 'name' => t('Submitter name'), 'message' => t('Message'), 'operations' => t('Delete'), );

  $rows = array();
  foreach(BdContactStorage::getAll() as $id=>$content) {
    // Row with attributes on the row and some of its cells.
    $rows[] = array( 'data' => array($id, $content->firstname, $content->lastname, $content->institution, $content->country, $content->year, $content->price, $content->bandwith, $content->informations, l('Delete', "admin/content/wacren_bandwith/delete/$id")) );
   }

   $table = array( '#type' => 'table', '#header' => $header, '#rows' => $rows, '#attributes' => array( 'id' => 'bd-contact-table', ), );
   return $add_link . drupal_render($table);
 }

  public function content1() {
    return array(
      '#type' => 'markup',
      '#markup' => t('Hello World'),
    );
  }


  function content() {
    $url = Url::fromRoute('wacren_bandwith_add');
    $url2 = Url::fromRoute('wacren_bandwith_graph');
    //$add_link = ;
    $add_link = '<p>' . \Drupal::l(t('New registration'), $url) . '</p> <p>'. \Drupal::l(t('Show graph'), $url2).'</p>';

    $text = array(
      '#type' => 'markup',
      '#markup' => $add_link,
    );

    // Table header.
    $header = array(
      'id' => t('Id'),
      'firstname' => t('firstname'),
      'lastname' => t('lastname'),
      'institution' => t('institution'),
      'country' => t('pays'),
       'month' => t('month'),
      'year' => t('year'),
      'price' => t('price'),
      'bandwith' => t('bandwith'),
      'informations' => t('infos'),
      'operations' => t('Delete'),
    );
    $rows = array();
    foreach (BdContactStorage::getAll() as $id => $content) {
      // Row with attributes on the row and some of its cells.
      $editUrl = Url::fromRoute('wacren_bandwith_edit', array('id' => $id));
      $deleteUrl = Url::fromRoute('wacren_bandwith_delete', array('id' => $id));

      $rows[] = array(
        'data' => array(
          \Drupal::l($id, $editUrl),
          $content->firstname, $content->lastname, $content->institution, $content->country, $content->month, $content->dyear, $content->price, $content->bandwith, $content->informations,
          \Drupal::l('Delete', $deleteUrl)
        ),
      );
    }
    $table = array(
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $rows,
      '#attributes' => array(
        'id' => 'wacren-bandwith-table',
      ),
    );
    //return $add_link . ($table);
    return array(
      $text,
      $table,
    );
  }


function hello_world_theme() {

    return array(
        'world' => array(
            'template' => 'world',
            'variables' => array('texte' => NULL)
        ),
    );

}

/* public function graphView()
  {
      return array(
      '#theme' => 'test_twig',
      '#test_var' => $this->t('Test Value'),
    );
  
  }*/

 public function graphshow() 
  {
      return [
      '#theme' => 'index',
      '#description' => 'foo',
      '#attributes' => [],
    ];
  }


 public function graphdata() {
    $rows = array();
      $account = \Drupal::currentUser();

    if ($account->id() == 1) {
      \Drupal::logger('wacren_bandwith')->debug("Site owner came here !");
    }
    else {
      \Drupal::logger('wacren_bandwith')->error(
          '%username (id=%id) came here : No one should be here but site owner.',
          array('%username' => $account->getUsername(), '%id' => $account->id())
          );
    }
    $response = new Response();
       foreach (BdContactStorage::getDataToChart() as $id => $content) {
  $rows[] = $content;

   } 
     $response->setContent(json_encode($rows));
     $response->headers->set('Content-Type', 'application/json');
//return $response;
 //$build['wacren_bandwith']['#attached']['library'][] = 'wacren_bandwith/wacren_bandwith';

    return $response;
     
  }

   public function graphdataByPays($country) {
    $rows = array();
      $account = \Drupal::currentUser();

    if ($account->id() == 1) {
      \Drupal::logger('wacren_bandwith')->debug("Site owner came here !");
    }
    else {
      \Drupal::logger('wacren_bandwith')->error(
          '%username (id=%id) came here : No one should be here but site owner.',
          array('%username' => $account->getUsername(), '%id' => $account->id())
          );
    }
    $response = new Response();
       foreach (BdContactStorage::getDataToChartByCountry($country) as $country => $content) {
  $rows[] = $content;

   } 
     $response->setContent(json_encode($rows));
     $response->headers->set('Content-Type', 'application/json');
//return $response;
 //$build['wacren_bandwith']['#attached']['library'][] = 'wacren_bandwith/wacren_bandwith';

    return $response;
     
  }

}
