@extends('web::layouts.grids.6-6')

@section('title', 'User Profile')
@section('page_header', 'User Profile')

@section('left')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">User Preferces</h3>
    </div>
    <div class="panel-body">

      <form role="form" action="{{ route('profile.update.settings') }}" method="post"
            class="form-horizontal">
        {{ csrf_field() }}

        <div class="box-body">

          <legend>User Interface</legend>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="main_character_id">Main Character</label>
            <div class="col-md-6">
              <select id="main_character_id" name="main_character_id" class="form-control">
                @foreach($characters as $character)
                  <option value="{{ $character->characterID }}"
                          @if(setting('main_character_id') == $character->characterID)
                            selected
                          @endif>
                    {{ $character->characterName }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="skin">SeAT Skin</label>
            <div class="col-md-6">
              <select id="skin" name="skin" class="form-control">
                @foreach($skins as $skin)
                  <option value="{{ $skin }}"
                          @if(setting('skin') == $skin)
                            selected
                          @endif>
                    {{ str_replace('skin-', '', $skin) }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="sidebar">Sidebar Size</label>
            <div class="col-md-6">
              <select id="sidebar" name="sidebar" class="form-control">
                @foreach($sidebar as $style)
                  <option value="{{ $style }}"
                          @if(setting('sidebar') == $style)
                          selected
                          @endif>
                    {{ str_replace('sidebar-', '', $style) }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <legend>Number Format</legend>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="thousand_seperator">Thousands Seperator</label>
            <div class="col-md-6">
              <div class="form-inline input-group">
                <select id="thousand_seperator" name="thousand_seperator" class="form-control">
                  @foreach($thousand as $seperator)
                    <option value="{{ $seperator }}" @if(setting('thousand_seperator') == $seperator) selected @endif>
                      @if($seperator == ' ')
                        (space)
                      @else
                        {{ $seperator }}
                      @endif
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="decimal_seperator">Decimal Seperator</label>
            <div class="col-md-6">
              <div class="form-inline input-group">
                <select id="decimal_seperator" name="decimal_seperator" class="form-control">
                  @foreach($decimal as $seperator)
                    <option value="{{ $seperator }}" @if(setting('decimal_seperator') == $seperator) selected @endif>
                      {{ $seperator }}
                    </option>
                  @endforeach
                </select>
              </div>
              <span class="help-block">
                Current format: {{ number(10000000.00) }}
              </span>
            </div>
          </div>

          <legend>Notifications</legend>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="email_notifications">Email Notifications</label>
            <div class="col-md-6">
              <div class="form-inline input-group">
                <select id="email_notifications" name="email_notifications" class="form-control">
                  <option value="yes"
                          @if(setting('email_notifications') == "yes") selected @endif>
                    Yes
                  </option>
                  <option value="no"
                          @if(setting('email_notifications') == "no") selected @endif>
                    No
                  </option>
                </select>
              </div>
            </div>
          </div>

          <legend>Multifactor Authentication</legend>

          <!-- Select Basic -->
          <div class="form-group">
            <label class="col-md-4 control-label" for="require_mfa">Require MFA</label>
            <div class="col-md-6">
              <div class="form-inline input-group">
                <select id="require_mfa" name="require_mfa" class="form-control">
                  <option value="yes"
                          @if(setting('require_mfa') == "yes") selected @endif>
                    Yes
                  </option>
                  <option value="no"
                          @if(setting('require_mfa') == "no") selected @endif>
                    No
                  </option>
                </select>
                <span class="help-block">
                  <p>
                    <b>Warning:</b> To use the two factor authentication, you
                                    will have to install a Google Authenticator
                                    compatible app on your smartphone.
                  </p>
                  <p>
                    @if(setting('require_mfa') == "yes")
                      <a href="{{ route('profile.mfa.new') }}">Setup Token Now</a>
                    @endif
                  </p>
                </span>
              </div>
            </div>
          </div>

        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <div class="form-group">
            <label class="col-md-4 control-label" for="submit"></label>
            <div class="col-md-4">
              <button id="submit" type="submit" class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
      </form>

    </div>
  </div>

@stop

@section('right')

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        User Account
        <span class="pull-right">
          Last Login: {{ auth()->user()->last_login }}
          ({{ human_diff(auth()->user()->last_login) }})
        </span>
      </h3>
    </div>
    <div class="panel-body">

      <div class="row">
        <div class="col-md-6">

          <ul class="list-unstyled">
            <li class="list-header">Account Settings</li>
            <li>

              <!-- Button trigger modal -->
              <a type="button" data-toggle="modal" data-target="#passwordModal">
                <i class="fa fa-lock"></i>
                Change Password
              </a>

              <!-- Modal -->
              <div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title" id="passwordModalLabel">Change Password</h4>
                    </div>
                    <div class="modal-body">

                      <form role="form" action="{{ route('profile.update.password') }}" method="post">
                        {{ csrf_field() }}

                        <div class="box-body">

                          <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" placeholder="Password">
                          </div>

                          <div class="form-group">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Password">
                          </div>

                          <div class="form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="password_confirmation" placeholder="Password">
                          </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                          <button type="submit" class="btn btn-primary pull-right">
                            Change Password
                          </button>
                        </div>
                      </form>

                    </div>
                  </div>
                </div>
              </div>

            </li>
            <li>

              <!-- Button trigger modal -->
              <a type="button" data-toggle="modal" data-target="#historyModal">
                <i class="fa fa-lock"></i>
                View Login History
              </a>

              <!-- Modal -->
              <div class="modal fade" id="historyModal" tabindex="-1" role="dialog" aria-labelledby="historyModalLabel">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                      <h4 class="modal-title" id="historyModalLabel">Login History</h4>
                    </div>
                    <div class="modal-body">

                      <table class="table table-condensed table-hover table-responsive">
                        <tbody>
                        <tr>
                          <th>Date</th>
                          <th>Action</th>
                          <th>Source</th>
                          <th>User Agent</th>
                        </tr>

                        @foreach($history as $entry)

                          <tr>
                            <td>
                              <span data-toggle="tooltip"
                                 title="" data-original-title="{{ $entry->created_at }}">
                                {{ human_diff($entry->created_at) }}
                              </span>
                            </td>
                            <td>{{ ucfirst($entry->action) }}</td>
                            <td>{{ $entry->source }}</td>
                            <td>{{ str_limit($entry->user_agent) }}</td>
                          </tr>

                        @endforeach

                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
              </div>

            </li>
          </ul>

        </div>
        <div class="col-md-6">

          <ul class="list-unstyled">
            <li class="list-header">Roles</li>
            @foreach($user->roles as $role)
              <li>
                <i class="fa fa-group"></i>
                <span @if($role->title == 'Superuser') class="text-danger" @endif>
                  {{ $role->title }}
                </span>
              </li>
            @endforeach
          </ul>

        </div>
      </div>

    </div>
    <div class="panel-footer">
      @if(auth()->user()->hasSuperUser())
        <span class="label label-danger">
          Superuser
        </span>
      @endif

      <span class="pull-right">
        {{ count($user->keys) }} owned keys.
      </span>
    </div>
  </div>

  <span class="text-center">
    For any account related enquiries, including permissions amendments, please contact the SeAT administrator.
  </span>

@stop

