<?php
	
	if( class_exists( 'WP_Customize_Control' ) ){
	
		class AKVO_CUSTOMIZE_DROPDOWN_CONTROL extends WP_Customize_Control{
			
			public $type = 'ajax_dropdown';
			
			// LEAVING IT EMPTY TO ALLOW JS RENDERING TO HAPPEN
			public function render_content() {}
			
			
			public function to_json() {

				// Call parent to_json() method to get the core defaults like "label", "description", etc.
				parent::to_json();

				// The setting value.
				$this->json['value'] = $this->value();

				// The control choices.
				$this->json['choices'] = $this->choices;

				// The data link.
				$this->json['link'] = $this->get_link();
			}
			
			public function content_template() {
				include "templates/customize-dropdown-control.php";
			}
			
			
		}
		
	}