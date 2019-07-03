// redirect user after login Based on roles

/**
 * Implements hook_user_login()
 */
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Url;

function player_user_login($account) {
   
   $current_user = \Drupal::currentUser();   
   $uid = $current_user->id(); 
   $user =  user_load($uid);
   $roles = $user->getRoles();
   if(in_array('player', $roles)){
      $url = \Drupal::url("player.home", ['uid' => $uid]);
      $response = new RedirectResponse($url);   
      $response->send();
      return;
   }     
         
 
   
}
