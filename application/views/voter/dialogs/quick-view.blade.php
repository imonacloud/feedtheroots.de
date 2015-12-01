 @if ( ! is_null($voter))
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <table>
    	<tr>
    		<td><img class="img-circle" src="{{ $voter->photo_thumb_url }}"></td>
    		<td>
    			<h3> {{ $voter->fullname }}</h3>
    			<small class="muted">Quick view of voter's electoral information.</small>
    		</td>
    	</tr>
    </table>
  </div>
  
  <div class="modal-body" id="modal-body">
	
				<ul class="nav nav-tabs" id="voterQuickViewTab">
				  <li class="active"><a href="#quick_view_electoral">Electoral</a></li>
				  <li><a href="#quick_view_vote_history">Vote History</a></li>
				  <li><a href="#quick_view_profile">Profile</a></li>
				  <li><a href="#quick_view_contact">Contact</a></li>
				  <li><a href="#quick_view_log">Logs</a></li>
				</ul>
				<div class="tab-content">

				  <!-- General Tab-->
				  <div class="tab-pane active" id="quick_view_electoral">
				    <div class="row-fluid">
				      <div class="span12">
				      	<table class="table table-condensed">
				      	  <thead>	
							<tr>
								<th>Voter ID</th>
								<td>{{ $voter->voter_id }}</td>
							</tr>
							<tr>
								<th><abbr title="Registration Date">Reg. Date</abbr></th>
								<td>{{ $voter->reg_date }}</td>
							</tr>
							<tr>
								<th>Status</th>
								<td>{{ $voter->status->name }}</td>
							</tr>
							<tr>
								<th>Election District</th>
								<td>{{ $voter->electiondistrict->number }}</td>
							</tr>
							<tr>
								<th>Poll Site</th>
								<td><a href="#" title="blabla" data-poload="#">{{ $voter->pollsite->name }}</a></td>
							</tr>
							<tr>
								<th>Assembly District</th>
								<td>{{ $voter->assemblydistrict->number }}</td>
							</tr>
							<tr>
								<th>Congress District</th>
								<td>{{ $voter->congress_district }}</td>
							</tr>
							<tr>
								<th>Council District</th>
								<td>{{ $voter->council_district }}</td>
							</tr>
							<tr>
								<th>Senate District</th>
								<td>{{ $voter->senate_district }}</td>
							</tr>
							<tr>
								<th>Civil Court District</th>
								<td>{{ $voter->civil_court_district }}</td>
							</tr>
							<tr>
								<th>Judicial District</th>
								<td>{{ $voter->Judicial_district }}</td>
							</tr>
						  </thead>	
						</table>
				      </div>
					</div>
				  </div>
				  <!-- vote history tab -->
				  <div class="tab-pane" id="quick_view_vote_history">
				    <div class="row-fluid">
				      <div class="span12">
				      	<table class="table table-condensed">
				      	  <thead>	
			              	<tr>
			                	<th>Voter History</th>
			              	</tr>
			              </thead>
			              <tbody> 	
			                @foreach($voter->votehistory()->where_voted('Y')->order_by('electiontype_id', 'DESC')->order_by('year', 'ASC')->get() as $votehistory)
			                <tr>
			                  	<td>{{ $votehistory->electiontype->name }} {{ $votehistory->year }}</td>
			                </tr>
			                @endforeach
			              </tbody>  
			              
			            </table>
				      </div>
				    </div>
				  </div>
				  <!-- Profile tab -->
				  <div class="tab-pane" id="quick_view_profile">
				    <div class="row-fluid">
				      <div class="span12">
				      	<table class="table table-condensed">
				      	  <thead>	
							<tr>
								<th>Fullname</th>
								<td>{{ $voter->fullname }}</td>
							</tr>
							<tr>
								<th>Date of birth</th>
								<td>{{ $voter->dob }}</td>
							</tr>
							<tr>
								<th>Country Of Origin</th>
								<td>{{ ($voter->ethnicgroup ? $voter->ethnicgroup->name : '') }}</td>
							</tr>
							<tr>
								<th>Ethnicity</th>
								<td>{{ ($voter->ethnicity ? $voter->ethnicity->name : '') }}</td>
							</tr>
							<tr>
								<th>Language</th>
								<td>{{ ($voter->language ? $voter->language->name : '') }}</td>
							</tr>
							<tr>
								<th>Religion</th>
								<td>{{ ($voter->religion ? $voter->religion->name : '') }}</td>
							</tr>
						  </thead>	
						</table>
				      </div>
				    </div>
				  </div>
				  <!-- contact tab -->
				  <div class="tab-pane" id="quick_view_contact">
				    <div class="row-fluid">
				      <div class="span12">
				      	<table class="table table-condensed">
				      	  <thead>	
							<tr>
								<th>Email</th>
								<td>{{ $voter->email }}</td>
							</tr>
							<tr>
								<th>Cell Number</th>
								<td>{{ $voter->phone_number }}</td>
							</tr>
							<tr>
								<th>Home Number</th>
								<td>{{ $voter->home_number }}</td>
							</tr>
							<tr>
								<th>Work Number</th>
								<td>{{ $voter->work_number }}</td>
							</tr>
							<tr>
								<th>Full Address</th>
								<td>{{ $voter->fulladdress }} {{ $voter->addressstatus_id>0 ? '<strong><span style="color: '.$voter->addressstatus->color.'">('.$voter->addressstatus->name.')</span></strong>' : ''}}</td>
							</tr>
						  </thead>	
						</table>
				      </div>
				    </div>
				  </div>

				  <!-- Log tab -->
				  <div class="tab-pane" id="quick_view_log">
				    <div class="row-fluid">
				      <div class="span12">
				      	<table class="table table-condensed">
				      	  <thead>	
							<tr>
								<th>Type</th>
								<th>Result</th>
								<th>Note</th>
								<th>User Name</th>
								<th>Date Time</th>
							</tr>
						  </thead>
						  <tbody>	
						  	@forelse($logs as $log)
							<tr>
								<td>{{ $log->source }}</td>
								<td style="color: {{ $log->color }}">{{ $log->result }}</td>
								<td>{{ $log->note }}</td>
								<td>{{ $log->user_name }}</td>
								<td>{{ $log->creation_date }}</td>
							</tr>
							@empty
							<tr>
								<td colspan="5">Not contact log has been found.</td>
							</tr>
							@endforelse
						  </tbody>	
						</table>
				      </div>
				    </div>
				  </div>


				</div>  


  </div>
  
  <div class="modal-footer">
    <a class="btn btn-link pull-left" href="{{ URL::to_action('voter@view', array($voter->id)) }}">View all information</a>
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
@else
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3><i class="icofont-exclamation-sign"></i> Error</h3>
  </div>
  <div class="modal-body" id="modal-body">
  The voter couldn't be found or you don't have permission to see it.
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i> Close</button>
  </div>
@endif
