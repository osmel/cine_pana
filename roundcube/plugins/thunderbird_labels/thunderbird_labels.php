<?php
/**
 * Thunderbird Labels Plugin for Roundcube Webmail
 *
 * Plugin to show the 5 Message Labels Thunderbird Email-Client provides for IMAP
 *
 * @version $Revision: 24 $
 * @author Michael Kefeder
 * @url http://code.google.com/p/rcmail-thunderbird-labels/
 */
class thunderbird_labels extends rcube_plugin
{
	public $task = 'mail';
	private $map;
	
	function init()
	{
		$rcmail = rcmail::get_instance();
		# -- disable plugin when printing message
		if ($rcmail->action == 'print')
			return;
		
		$this->include_script('tb_label.js');
		$this->add_texts('localization/', true);
		$this->add_hook('messages_list', array($this, 'read_flags'));
		$this->add_hook('message_load', array($this, 'read_single_flags'));
		$this->add_hook('template_object_messageheaders', array($this, 'color_headers'));
		$this->add_hook('render_page', array($this, 'tb_label_popup'));
		$this->include_stylesheet($this->local_skin_path() . '/tb_label.css');
		
		$this->name = get_class($this);
		$this->prefs = array('show_labels' => true);
		# -- additional TB flags
		$this->add_tb_flags = array(
			'LABEL1' => '$Label1',
			'LABEL2' => '$Label2',
			'LABEL3' => '$Label3',
			'LABEL4' => '$Label4',
			'LABEL5' => '$Label5',
			);
		$this->message_tb_labels = array();
		
		$this->add_button(
			array(
				'command' => 'plugin.thunderbird_labels.rcm_tb_label_submenu',
				'id' => 'tb_label_popuplink',
				'title' => 'label', # gets translated
				'domain' => $this->ID,
				'type' => 'link',
				'content' => ' ', # maybe put translated version of "Labels" here?
				'class' => ($rcmail->config->get('skin') == 'larry') ? 'button' : 'tb_noclass',
			),
			'toolbar'
		);
		
		$this->register_action('plugin.thunderbird_labels.set_flags', array($this, 'set_flags'));
		
		
		if (method_exists($this, 'require_plugin')
			&& in_array('contextmenu', $rcmail->config->get('plugins'))
			&& $this->require_plugin('contextmenu'))
		{
			if ($rcmail->action == '')
				$this->add_hook('render_mailboxlist', array($this, 'show_tb_label_contextmenu'));
		}
	}
	
	public function show_tb_label_contextmenu($args)
	{
		$rcmail = rcmail::get_instance();
		$this->add_texts('localization/');
		#$this->api->output->add_label('copymessage.copyingmessage');

		$li = html::tag('li', array('class' => 'submenu'), Q($this->gettext('label')) . $this->_gen_label_submenu($args, 'tb_label_ctxm_submenu'));
		$out .= html::tag('ul', array('id' => 'tb_label_ctxm_mainmenu'), $li);
		$this->api->output->add_footer(html::div(array('style' => 'display: none;'), $out));
	}
	
	private function _gen_label_submenu($args, $id)
	{
		$rcmail = rcmail::get_instance();
		$out = '';
		for ($i = 0; $i < 6; $i++)
		{
			$separator = ($i == 0)? ' separator_below' :'';
			$out .= '<li class="label'.$i.$separator.' ctxm_tb_label"><a href="#ctxm_tb_label" class="active" onclick="rcmail_ctxm_label_set('.$i.')">'.$i.' '.$this->gettext('label'.$i).'</a></li>';
		}
		$out = html::tag('ul', array('class' => 'popupmenu toolbarmenu folders', 'id' => $id), $out);
		return $out;
	}
	
	public function read_single_flags($args)
	{
		#write_log($this->name, print_r(($args['object']), true));
		if (!count($this->prefs) 
			or !isset($args['object']) 
			)
				return;
		
		if (is_array($args['object']->headers->flags))
		{
			$this->message_tb_labels = array();
			foreach ($args['object']->headers->flags as $flagname => $flagvalue)
			{
				$flag = is_numeric("$flagvalue")? $flagname:$flagvalue;// for compatibility with < 0.5.4
				$flag = strtolower($flag);
				if (preg_match('/^\$?label/', $flag))
				{
					$flag_no = preg_replace('/^\$?label/', '', $flag);
					#write_log($this->name, "Single message Flag: ".$flag." Flag_no:".$flag_no);
					$this->message_tb_labels[] = (int)$flag_no;
				}
			}
		}
		# -- no return value for this hook
	}
	
	/**
	*	Writes labelnumbers for single message display
	*	Coloring of Message header table happens via Javascript
	*/
	public function color_headers($p)
	{
		#write_log($this->name, print_r($p, true));
		# -- always write array, even when empty
		$p['content'] .= '<script type="text/javascript">
		var tb_labels_for_message = ['.join(',', $this->message_tb_labels).'];
		</script>';
		return $p;
	}
	
	public function read_flags($args)
	{
		#write_log($this->name, print_r($args, true));
		// add color information for all messages
		#$rcmail = rcmail::get_instance();
		#$this->prefs = $rcmail->config->get('thunderbird_labels', array());
		// dont loop over all messages if we dont have any highlights or no msgs
		if (!count($this->prefs) 
			or !isset($args['messages']) 
			or !is_array($args['messages']))
				return $args;

		// loop over all messages and add $LabelX info to the extra_flags
		foreach($args['messages'] as $message)
		{
			#write_log($this->name, print_r($message->flags, true));
			$message->list_flags['extra_flags']['tb_labels'] = array(); # always set extra_flags, needed for javascript later!
			if (is_array($message->flags))
			foreach ($message->flags as $flagname => $flagvalue)
			{
				$flag = is_numeric("$flagvalue")? $flagname:$flagvalue;// for compatibility with < 0.5.4
				$flag = strtolower($flag);
				if (preg_match('/^\$?label/', $flag))
				{
					$flag_no = preg_replace('/^\$?label/', '', $flag);
					#write_log($this->name, "Flag:".$flag." Flag_no:".$flag_no);
					$message->list_flags['extra_flags']['tb_labels'][] = (int)$flag_no;
				}
			}
		}
		return($args);
	}
	
	function set_flags()
	{
		#write_log($this->name, print_r($_GET, true));

		$rcmail = rcmail::get_instance();
		$imap = $rcmail->imap;
		$cbox = get_input_value('_cur', RCUBE_INPUT_GET);
		$mbox = get_input_value('_mbox', RCUBE_INPUT_GET);
		$toggle_label = get_input_value('_toggle_label', RCUBE_INPUT_GET);
		$flag_uids = get_input_value('_flag_uids', RCUBE_INPUT_GET);
		$flag_uids = explode(',', $flag_uids);
		$unflag_uids = get_input_value('_unflag_uids', RCUBE_INPUT_GET);
		$unflag_uids = explode(',', $unflag_uids);
		
		$imap->conn->flags = array_merge($imap->conn->flags, $this->add_tb_flags);
		
		#write_log($this->name, print_r($flag_uids, true));
		#write_log($this->name, print_r($unflag_uids, true));

		if (!is_array($unflag_uids)
			|| !is_array($flag_uids))
			return false;

		$imap->set_flag($flag_uids, $toggle_label, $mbox);
		$imap->set_flag($unflag_uids, "UN$toggle_label", $mbox);

		$this->api->output->send();
	}
	
	function tb_label_popup()
	{
		$rcmail = rcmail::get_instance();
		$out = '<div id="tb_label_popup" class="popupmenu">
			<ul class="toolbarmenu">';
		for ($i = 0; $i < 6; $i++)
		{
			$separator = ($i == 0)? ' separator_below' :'';
			$out .= '<li class="label'.$i.$separator.'"><a href="#" class="active">'.$i.' '.$this->gettext('label'.$i).'</a></li>';
		}
		$out .= '</ul>
		</div>';
		$rcmail->output->add_gui_object('tb_label_popup_obj', 'tb_label_popup');
    	$rcmail->output->add_footer($out);
	}
}
?>
