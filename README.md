SAMPLE APPLICATION - Nallitrack
Nallitrack is a SaaS solution for managing track and field meets and teams. It is built on the LAMP technology stack, and uses the PHP development framework "CodeIgniter" (http://Codeigniter.com). Feel free to browse the site http:codeigniter.nallimcmerdna.com.


There's sample data here. To find some, search for a meet entering the following criteria
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
Here's where the nallitrack PHP application resides, with the bulk of the application specific code in the "models", "views", or "controllers" directories. CodeIgniter is based on the Model-View-Controller development pattern, and the Nallitrack inplements that design pattern. Here are the controllers and their public methods. As you browse through the site you'll see a direct relationship between the URL and list below.

controller	public methods
----------	--------------
go/	
go/		view/
Dashboard/	
Account/	
Account/	login/
Account/	logout/
Account/	register/
Account/	send_again/
Account/	activate/
Account/	forgot_password/
Account/	reset_password/
Account/	change_password/
Account/	change_email/
Account/	reset_email/
Account/	unregister/
Account/	change_status/
Meet/		
Meet/		search/
Meet/		search_results/
Meet/		report/
Meet/		edit/
Meet/		delete/
Meet/		add_to_schedule/
Meet/		remove_from_schedule/
Meet/		generate_event_sched/
Meet/		regenerate_event_sched/
Meet/		adjust_event_sched/
Meet/		assign_my_athletes/
Meet/		edit_my_assignments/
Meet/		record_results/
Meet/		archive/
Meet/		restore_archive/
Athlete/	
Athlete/	search/
Athlete/	search_results/
Athlete/	report/
Athlete/	edit/
Athlete/	delete/
Athlete/	edit_events/
Team/	
Team/		search/
Team/		search_results/
Team/		edit/
