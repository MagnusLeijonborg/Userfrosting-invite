Userfrosting-invite
===================

A plugin to userfrosting for adding a simple invite function

This is a very preliminary version with a number of known bugs and limitations. 

To install:

Create a subdirectory called "modules" to your main Userfrosting directory.
Copy my plugin directory to the module directory and rename it "invite"
Run the file modules/invite/install/install.php This file will create two new tables in the Userfrosting database and add a new menu item. It will not add or change any files in the Userfrosting directory structure.
To make it work you need to do two things:

Manually create a new row in the uf_user_invites table for each user that should have invites. Add a user id and the number of invites that user have. I haven't figured out how to add a row automatically when a new user register without changing the user registration page.
copy the file modules/invite/models/mail-templates/new-invitation.txt tothe models/mail-templates directory.
That should do it. There is some known bugs and most likely some unknown. There is also some cleaning up to do, for example hard coded table names, but i wanted to show what i have so far.

The plugin is lacking a configuration page, but after som e debugging that's the next thin to do.

I probably missed some important things about how a Userfrosting plugin should work, so don't hesitate to give me feedback!

/Magnus
