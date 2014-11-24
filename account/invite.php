
 
  
  
  <?php
/*

UserFrosting Version: 0.2.1 (beta)
By Alex Weissman
Copyright (c) 2014

Based on the UserCake user management system, v2.0.2.
Copyright (c) 2009-2012

UserFrosting, like UserCake, is 100% free and open-source.

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the 'Software'), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:
The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

require_once("../../../models/config.php");
require_once("../models/invite_funcs.php");


if (!securePage(__FILE__)){
  // Forward to index page
  addAlert("danger", "Whoops, looks like you don't have permission to view that page.");
  header("Location: index.php");
  exit();
}

setReferralPage(getAbsoluteDocumentPath(__FILE__));



?>

<!DOCTYPE html>
<html lang="en">
  <?php
  	echo renderAccountPageHeader(array("#SITE_ROOT#" => SITE_ROOT, "#SITE_TITLE#" => SITE_TITLE, "#PAGE_TITLE#" => "Account Settings"));
  ?>

  <body>
    <div id="wrapper">

      <!-- Sidebar -->
        <?php
          echo renderMenu("invite");
        ?>  

      <div id="page-wrapper">
	  	<div class="row">
          <div id='display-alerts' class="col-lg-12">

          </div>
        </div>
		<h1>Invite a friend</h1>
		<div id="inviteform" class="row">
		  <div class="col-lg-6">
	   <form name='newUser' id='newInvite' class='form-horizontal' role='form' action='../api/create_invite.php' method='post'>
		  <div class="row">
				<div id='display-alerts' class="col-lg-12">
		  
				</div>
		  </div>		
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Name</label>
			<div class="col-sm-8">
			    <div class="input-group">
                    <span class='input-group-addon'><i class='fa fa-edit'></i></span>
					<input type="text" class="form-control" placeholder="Name" name = 'name' value='' data-validate='{"minLength": 1, "maxLength": 25, "label": "Name" }'>
				</div>
			</div>
		  </div>
		 
		  <div class="row form-group">
			<label class="col-sm-4 control-label">Email</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-envelope'></i></span>
					<input type="email" class="form-control" placeholder="Email" name='email' data-validate='{"email": true, "minLength": 1, "maxLength": 150, "label": "Email" }'>
				</div>
			</div>
		  </div>		  
		 <div class="row form-group">
			<label class="col-sm-4 control-label">Message</label>
			<div class="col-sm-8">
				<div class="input-group">
					<span class='input-group-addon'><i class='fa fa-edit'></i></span>
					<input type="text" class="form-control" placeholder="Message" name='message' data-validate='{ "minLength": 0, "maxLength": 512, "label": "Message" }'>
				</div>
			</div>
		  </div>	
		  <br>
		    <input type="hidden" name="csrf_token" value="<?php echo $loggedInUser->csrf_token; ?>" />
		  <input type="hidden" name="user_id" value="0" />
		  <div class="form-group">
			<div class="col-sm-12">
			  <button type="submit" class="btn btn-success submit" value='Send Invite!'>Send invite!</button>
			</div>
		  </div>
		</form>
		  </div>
		</div>
	  </div>
	</div>
	
	<script>
        $(document).ready(function() {
          // Get id of the logged in user to determine how to render this page.
          var user = loadCurrentUser();
          var user_id = user['user_id'];
          
		  alertWidget('display-alerts');

		
		  var request;
		  $("form[name='newUser']").submit(function(event){
			var url = '../api/create_invite.php';
			// abort any pending request
			if (request) {
				request.abort();
			}
			var $form = $(this);
			var $inputs = $form.find("input");
			// post to the backend script in ajax mode
			var serializedData = $form.serialize() + '&ajaxMode=true';
			// Disable the inputs for the duration of the ajax request
			$inputs.prop("disabled", true);
		
			// fire off the request
			request = $.ajax({
				url: url,
				type: "post",
				data: serializedData
			})
			.done(function (result, textStatus, jqXHR){
			//	console.log("result: "+result);
				var resultJSON = processJSONResult(result);
				// Render alerts
				alertWidget('display-alerts');
				$( "#inviteform" ).replaceWith( "<h2>Thank you!</h2><br>You have "+resultJSON['invitesLeft']+" invites left." );
				
			
			}).fail(function (jqXHR, textStatus, errorThrown){
				// log the error to the console
				console.error(
					"The following error occured: "+
					textStatus, errorThrown
				);
			}).always(function () {
				// reenable the inputs
				$inputs.prop("disabled", false);
			});
		
			// prevent default posting of form
			event.preventDefault();  
		  });

		});
	</script>
  </body>
</html>
