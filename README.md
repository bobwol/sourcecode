Nallitrack is a SaaS solution for managing track and field meets and teams. It is built on the LAMP technology stack, and uses the PHP development framework "CodeIgniter" (http://Codeigniter.com). Feel free to browse the site http://Nallitrack.com. The site is restricted so you'll need login info

	user: demo 
	password: RtrdTZdWos)3

There's sample data here. To find some search for a meet entering the following criteria
	date range - select month, then select either mar, apr, or may of 2012
	State - select georgia

Here's a little bit about the directories in this source.

system
------
CodeIgniter specific directory used to support the framework. Little to no nallitrack customizations have been done here

public_html
-----------
Public facing css, images and javascript go here.  However, the actual PHP application source is located in the application folder. This is a function of how CodeIgniter is configured.

application
-----------
Here's where the nallitrack PHP application resides, with the bulk of the application specific code in the "models", "views", or "controllers" directories. CodeIgniter is based on the Model-View-Controller development pattern, but implements a fairly loose approach since Models are not required. Here are the controllers and their public methods. As you browse through the site you'll see a direct relationship between the URL and list below.

controller	public methods										parameters
----------	--------------										----------
Search			index/
Search			meets/
Search			teams/	
Search			athletes/
Search			meet_search_results/		
Search			team_search_results/
Search			athlete_search_results/	
Meet				index/	
Meet				report/														meetid
Meet				edit/															meetid
Meet				delete/	
Meet				add_to_schedule/									meetid
Meet				remove_from_schedule/							meetid
Meet				generate_sched_of_events/					meetid	
Meet				save_sched_of_events/	
Meet				adjust_sched_of_events/						meetid
Meet				save_sched_adjustments/	
Meet				assign_my_athletes/								meetid
Meet				edit_my_assignments/							meetid
Meet				save_my_assignments/	
Meet				record_results/	seid
Meet				save_record_results/	
Meet				archive/	
Meet				restore_archive/	
Athlete			index/	
Athlete			report/	athleteid
Athlete			edit/	athleteid
Athlete			delete/	
Athlete			edit_eventlist/										athleteid
Team				index/	
Team				report/	teamid
Team				edit/	teamid
Dashboard		index/	
Go					index/	
Go					view/															page
Go					login/	
Go					logout/	
Go					register/	
Go					send_again/	
Go					activate/													user_id, new_email_key
Go					forgot_password/	
Go					reset_password/										user_id, new_email_key
Go					change_password/	
Go					change_email/	
Go					reset_email/											user_id, new_email_key
Go					unregister/	
