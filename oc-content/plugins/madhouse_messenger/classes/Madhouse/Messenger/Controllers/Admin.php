<?php

class Madhouse_Messenger_Controllers_Admin extends AdminSecBaseModel
{
	public function __construct() {
		parent::__construct();
		$this->ajax = true;

		// Inits DAO objects.
		$this->statusDAO = Madhouse_Messenger_Models_Status::newInstance();
		$this->messagesDAO = Madhouse_Messenger_Models_Messages::newInstance();
		$this->threadsDAO = Madhouse_Messenger_Models_Threads::newInstance();
	}

	/**
	 * Loads the dashboard view.
	 * @since 1.12
	 */
	private function doDashboard()
	{
	    // Exports stats for the dashboard.
	    $this->_exportVariableToView("messages_count", $this->messagesDAO->count());
	    $this->_exportVariableToView("threads_count", $this->threadsDAO->count());

	    $this->_exportVariableToView("messages_count_today", $this->messagesDAO->countToday());
	    $this->_exportVariableToView("threads_count_today", $this->threadsDAO->countToday());
	    $this->_exportVariableToView("messages_count_yesterday", $this->messagesDAO->countYesterday());
	    $this->_exportVariableToView("threads_count_yesterday", $this->threadsDAO->countYesterday());

	    $this->_exportVariableToView("threads_count_this_week", $this->threadsDAO->countThisWeek());
	    $this->_exportVariableToView("threads_count_last_week", $this->threadsDAO->countLastWeek());
	    $this->_exportVariableToView("messages_count_this_week", $this->messagesDAO->countThisWeek());
	    $this->_exportVariableToView("messages_count_last_week", $this->messagesDAO->countLastWeek());

	    $this->_exportVariableToView("threads_count_this_month", $this->threadsDAO->countThisMonth());
	    $this->_exportVariableToView("threads_count_last_month", $this->threadsDAO->countLastMonth());
	    $this->_exportVariableToView("messages_count_this_month", $this->messagesDAO->countThisMonth());
	    $this->_exportVariableToView("messages_count_last_month", $this->messagesDAO->countLastMonth());
	}

	/**
	 * Loads the "Manage Messages" view.
	 * @since 1.12
	 */
	private function doMessages()
	{
	    $iPage = Params::getParam("iPage");
        if(!isset($iPage) || empty($iPage)) {
            $iPage = 1;
            Params::setParam("iPage", $iPage);
        }

        $iDisplayLength = Params::getParam("iDisplayLength");
        if(!isset($iDisplayLength) || empty($iDisplayLength)) {
            $iDisplayLength = 50;
            Params::setParam("iDisplayLength", $iDisplayLength);
        }

        $filterType = Params::getParam("filter-type");
        $thread = Params::getParam("threadId");
        $user = Params::getParam("userId");
        $item = Params::getParam("itemId");
        if($filterType == "oThread" && isset($thread) && !empty($thread)) {
            $t = null;
            try {
                $t = $this->threadsDAO->findByPrimaryKey($thread);
            } catch(Exception $e) {
                mdh_handle_error(
                    __("The requested message / conversation does not exists.", mdh_current_plugin_name()),
                    mdh_messenger_admin_messages_url()
                );
            }

            osc_add_filter("custom_listing_title", function($s) use ($t) {
                return sprintf(__("Messages of '%s' (Thread: #%d)",
                    mdh_current_plugin_name()),
                    implode(", ", array_map(function($u) { return $u->getName(); }, $t->getUsers())),
                    $t->getId());
                }
            );

            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByThread($t, $iPage, $iDisplayLength)
            );
            $this->_exportVariableToView("count", $this->messagesDAO->countByThread($thread));

        } else if ($filterType == "oUser" && isset($user) && !empty($user)) {
            $u = null;
            try {
                $u = Madhouse_Utils_Models::findUserByPrimaryKey($user);
            } catch (Exception $exception) {
                mdh_handle_error(
                    __("The requested user does not exist.", mdh_current_plugin_name()),
                    mdh_messenger_admin_messages_url()
                );
            }

            osc_add_filter("custom_listing_title", function($s) use ($u) {
                return sprintf(__("%s's messages (User: #%d)", mdh_current_plugin_name()), $u->getName(), $u->getId());
            });

            $this->_exportVariableToView("count", $this->messagesDAO->countByUser($u));
            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByUser($u, array(), $iPage, $iDisplayLength)
            );
        } else if($filterType == "oItem" && isset($item) && !empty($item)) {
            $this->_exportVariableToView("count", $this->messagesDAO->countByItem($item));
            $this->_exportVariableToView(
                "mdh_messages",
                $this->messagesDAO->findByItem($item, $iPage, $iDisplayLength)
            );
        } else {
            $this->_exportVariableToView("count", $this->messagesDAO->count());
            $this->_exportVariableToView("mdh_messages", $this->messagesDAO->findAll($iPage, $iDisplayLength));
        }
	}

	/**
	 * Load the settings view.
	 * @since 1.12
	 */
	private function doSettings()
	{
	    $this->_exportVariableToView("statuses", $this->statusDAO->findAll());
	    $this->_exportVariableToView("user",
	        User::newInstance()->findByPrimaryKey(
	            osc_get_preference('moderation_user', mdh_current_preferences_section())
	        )
	    );
	}

	/**
	 * Save the settings and redirect to settings view.
	 * @since 1.12
	 */
	private function doSettingsPost()
	{
        $reminderEvery = Params::getParam("reminder_every");
        if($reminderEvery <= 1) {
            // Illegal value for reminder_every.
            mdh_handle_error(
                sprintf(__("Can't send reminder every '%s' new messages. Must be greater than 1.", mdh_current_plugin_name()), $reminderEvery),
                mdh_messenger_admin_settings_url()
            );
        }

        Madhouse_Utils_Controllers::doSettingsPost(
            array(
                "display_usermenu_link",
                "moderation_user",
                "automessage_item_deleted",
                "automessage_item_spammed",
                "automessage_newer_days",
                "base_url",
                "enable_notifications",
                "email_excerpt_length",
                "email_excerpt_oneline",
                "notify_everytime",
                "stop_notify_after",
                "enable_reminders",
                "reminder_every",
                "reminder_every_days",
                "stop_reminder_after",
                "enable_status",
                "default_status",
                "status_for_owner_only",
                "enable_message_template",
            ),
            Params::getParamsAsArray("post"),
            mdh_messenger_admin_settings_url()
        );
	}

	/**
	 * Blocks/Unblocks a message (for spam) and redirect to manage messages view.
	 * @since 1.12
	 */
	private function doBlock($block=true)
	{
        $messagesId = Params::getParam("id");
        if(!empty($messagesId)) {
            $message = null;
            foreach ($messagesId as $messageId) {
                try {
                    $message = $this->messagesDAO->findByPrimaryKey($messageId);
                    if(($block && ! $message->isBlocked()) || (! $block && $message->isBlocked())) {
                        $this->messagesDAO->block($message->getId(), $block);
                    }
                } catch(Exception $e) {
                    mdh_handle_error(
                        __("Something went wrong blocking the message(s)", mdh_current_plugin_name()),
                        mdh_messenger_inbox_url()
                    );
                }
            }
        }

        mdh_handle_ok(
            __("Successfully blocked the message!", mdh_current_plugin_name()),
            mdh_messenger_admin_messages_url()
        );
	}

    private function doUnblock($block=true)
    {
        $this->doBlock(false);
    }

	public function doContact()
	{
	    $url = osc_admin_base_url(true) . "?page=users";

	    if(! osc_get_preference("moderation_user", mdh_current_preferences_section())) {
	        mdh_handle_error(
	            __("Please, head to settings to select a moderation user.", mdh_current_plugin_name()),
	            $url
	        );
	    }

	    // Gets the user to contact.
	    $this->_exportVariableToView("user", User::newInstance()->findByPrimaryKey(Params::getParam("recipients")));

	    // If 'message' exists, it means a message is sent.
	    if(Params::existParam("message")) {
	        // Contact the user with the moderator account as sender.
	        try {
    	        Madhouse_Messenger_Actions::contact(
    	            Params::getParam("message"),
    	            Madhouse_Utils_Models::findUserByPrimaryKey(
    	                osc_get_preference("moderation_user", mdh_current_preferences_section())
    	            ),
    	            array(Madhouse_Utils_Models::findUserByPrimaryKey(Params::getParam("recipients")))
    	        );
    	    } catch (Madhouse_Messenger_EmptyMessageException $e) {
    	        mdh_handle_error(__("Can't send an empty message.", mdh_current_plugin_name()), $url);
    	    } catch (Madhouse_Messenger_NoValidRecipientsException $e) {
    	        mdh_handle_error(__("Select a user to send the message to and choose the 'Contact' action.", mdh_current_plugin_name()), $url);
    	    } catch (Madhouse_QueryFailedException $e) {
    	        mdh_handle_error(__("An error occured while performing the task.", mdh_current_plugin_name()), $url);
    	    }

	        mdh_handle_ok(__("Successfully sent the message!", mdh_current_plugin_name()), $url);
	    }
	}

    public function doUpgrade()
    {
        $pluginInfo = Plugins::getInfo(mdh_current_plugin_name(true));

        $this->_exportVariableToView(
            "installed_version",
            osc_get_preference("version", mdh_current_preferences_section())
        );
        $this->_exportVariableToView(
            "current_version",
            $pluginInfo["version"]
        );

        $this->_exportVariableToView(
            "mdh_threads_count",
            Madhouse_Messenger_Models_Threads::newInstance()->count()
        );
    }

    public function doUpgradePost()
    {
        // Current version.
        $current = Plugins::getInfo(mdh_current_plugin_name(true));

        // Installed version.
        $installed = osc_get_preference("version", mdh_current_preferences_section());

        /*
         * 'version' is not set in the oc_t_preference table.
         * Assume that installed is 1.2X since version exists since 1.30 and 1.20
         * has been the first public version of the plugin. See CHANGELOG.
         */
        try {
            Madhouse_Messenger_Plugin::upgrade();
        } catch (Exception $e) {
            mdh_handle_error(
                __("An error occured while performing the upgrade.", mdh_current_plugin_name()),
                mdh_messenger_admin_dashboard_url()
            );
        }

        mdh_handle_ok(
            __("Well done. Successfully updated messenger!", mdh_current_plugin_name()),
            mdh_messenger_admin_dashboard_url()
        );
    }

	public function doModel()
	{
        parent::doModel();

        switch (Params::getParam("route")) {
            case mdh_current_plugin_name() . "_upgrade":
                $this->doUpgrade();
            break;
            case mdh_current_plugin_name() . "_upgrade":
                $this->doUpgradePost();
            break;
            case mdh_current_plugin_name() . "_listing":
                $this->doMessages();
            break;
            case mdh_current_plugin_name() . "_settings":
                $this->doSettings();
            break;
            case mdh_current_plugin_name() . "_settings_post":
                $this->doSettingsPost();
            break;
            case mdh_current_plugin_name() . "_message_unblock":
                $this->doUnblock();
            break;
            case mdh_current_plugin_name() . "_message_block":
                $this->doBlock();
            break;
            case mdh_current_plugin_name() . "_contact":
                $this->doContact();
            break;
            case mdh_current_plugin_name() . "_dashboard":
            default:
                $this->doDashboard();
            break;
        }
	}
}

?>