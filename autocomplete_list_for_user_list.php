// drupal 8 autocomplete for user list
public function buildForm(array $form, FormStateInterface $form_state) {
      
    global $base_url;

    $form['search_user'] = array(
	    '#required' => TRUE,
	    '#title' => $this->t('User'),
		  '#type' => 'entity_autocomplete',
		  '#target_type' => 'user',
		  '#required' => TRUE,
		  '#selection_settings' => [
		    'include_anonymous' => FALSE,
		    'filter' => [
		      'role' => ['parent'],
		    ],
		  ],   
    );      

    $form['title'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#size' => 40,
      '#maxlength' =>64,  
    );
     
