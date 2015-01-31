<?php

$meta_box['post'] = array(
	'id' => 'post-format-link',
	'title' => 'Additional Meta box for Post Format Link',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => 'Link-URL',
			'desc' => 'URL for the link (please, use http at first, its mandatory)',
			'id' => 'pf_link_url',
			'type' => 'text',
			'default' => ''
		),
		array(
			'name' => 'Quote-Source',
			'desc' => '(Optional) URL to the quote source (please, use http at first, its mandatory)',
			'id' => 'pf_link_source',
			'type' => 'text',
			'default' => ''
		),
		array(
			'name' => 'Textarea',
			'desc' => 'Its your text area',
			'id' => 'pf_link_textarea',
			'type' => 'textarea',
			'default' => ''
		),
		array(
			'name' => 'Select',
			'desc' => 'Its your select area',
			'id' => 'pf_link_select',
			'type' => 'select',
			'default' => '',
			'options' => array(
				'option1' => 'Option 1',
				'option2' => 'Option 2',
			)
		),
		array(
			'name' => 'Radio',
			'desc' => 'Its your radio area',
			'id' => 'pf_link_radio',
			'type' => 'radio',
			'default' => '',
			'options' => array(
				'radio1' => 'Radio 1',
				'radio2' => 'Radio 2',
				'radio3' => 'Radio 3',
			)
		),
		array(
			'name' => 'Checkbox',
			'desc' => 'Its your checkbox area',
			'id' => 'pf_link_checkbox',
			'type' => 'checkbox',
			'default' => '',
			'options' => array(
				'checkbox1' => 'Checkbox 1',
				'checkbox2' => 'Checkbox 2',
				'checkbox3' => 'Checkbox 3',
			)
		),			
	)
);

add_action('add_meta_boxes', 'recruit_meta_box');

function recruit_meta_box() {
	global $meta_box;

	foreach ($meta_box as $post_type => $value) {
		add_meta_box($value['id'], $value['title'], 'recruit_format_meta_box', $post_type, $value['context'], $value['priority']);
	}
}


function recruit_format_meta_box() {
	global $meta_box, $post;

	// Use nonce for verification
	echo '<input type="hidden" name="recruit_meta_box_nonce" value="'. wp_create_nonce(basename(__FILE__)) .'"></input>';
	echo '<table class="form-table">';

	foreach ($meta_box[$post->post_type]['fields'] as $field) {
		// get current post meta data
		$meta = get_post_meta($post->ID, $field['id'], true);

		echo '<tr>';
		echo '<th style="width:20%">';
		echo '<label for="'. $field['id'] .'">'. $field['name'] .'</label></th>';
		echo '<td>';

		switch ($field['type']) {
			case 'text':
				echo '<input type="text" name="'. $field['id'] .'" id="'. $field['id'] .'" value="'. ($meta ? $meta : $field['default']) .'" size="30" style="width:97%" /><br /><p class="desc">'. $field['desc'] .'</p>';
				break;

			case 'textarea':
				echo '<textarea name="'. $field['id'] .'" id="'. $field['id'] .'" col="60" rows="4" style="width:97%">'. ($meta ? $meta : $field['default']) .'</textarea><br /><p class="desc">'. $field['desc'] .'</p>';
				break;

			case 'select':
				echo '<select name="'. $field['id'] .'" id="'. $field['id'] .'">';
				foreach ($field['options'] as $key => $value) {
					echo '<option '. ($meta == $value ? 'selected="selected"' : '') .' value="'. $key .'">'. $value .'</option>';
				}
				echo '</select>';
				break;

			case 'radio':
				foreach ($field['options'] as $key => $value) {
					echo '<p><input type="radio" id="'. $key .'" name="'. $field['id'] .'" value="'. $key .'" /><label for="'. $key .'">'. $value .'</label></p>';
				}
				break;

			case 'checkbox':
				foreach ($field['options'] as $key => $value) {
					echo '<p><input type="checkbox" id="'. $key .'" name="'. $field['id'] .'" value="'. $key .'" /><label for="'. $key .'">'. $value .'</label></p>';
				}
				break;
			
			default:
				# code...
				break;
		}

		echo '</td>';
		echo '</tr>';
	}

	echo '</table>';
}

add_action('save_post', 'recruit_save_metabox_data');
// save data from meta_box
function recruit_save_metabox_data() {
	global $meta_box, $post;

	// verify nonce
	if (!wp_verify_nonce($_POST['recruit_meta_box_nonce'], basename(__FILE__))) {
		return $post_id;
	}

	// check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return $post_id;
	}

	// check permission
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id)) {
			return $post_id;
		} elseif (!current_user_can('edit_post', $post_id)) {
			return $post_id;
		}
	}

	// loop through fields and save the data
	foreach ($meta_box[$post->post_type]['fields'] as $field) {
		$old = get_post_meta($post_id, $field['id'], true);
		$new = $_POST[$field['id']];

		if ($new && $new != $old) {
			update_post_meta($post_id, $field['id'], true);
		} elseif ('' == $new && $old || !isset($_POST[$field['id']])) {
			delete_post_meta($post_id, $field['id'], $old);
		}
	}
}