<?php
$connectEmailAddress = "";
$connectEmailPassword = "";
$connectDomainURL = "";
$nMsgCount = "";
if (Auth::user()->connect_email != "" && Auth::user()->connect_password) {
    try {
        $connectEmailAddress = Auth::user()->connect_email; // Full email address
        $connectEmailPassword = Auth::user()->connect_password;        // Email password
        $connectDomainURL = substr($connectEmailAddress, strpos($connectEmailAddress, "@") + 1);
        $useHTTPS = true;
    } catch (Exception $e) {

    }
}


?>

<div class="app-header  navbar-md">
    <div class="navbar">
        <!-- Open side - Naviation on mobile -->
        <a data-toggle="modal" data-target="#aside" class="navbar-item pull-left hidden-lg-up">
            <i class="material-icons">&#xe5d2;</i>
        </a>
        <!-- / -->

        <!-- Page title - Bind to $state's title -->
        <div class="navbar-item pull-left h5" ng-bind="$state.current.data.title" id="pageTitle"></div>

        <!-- navbar right -->
        <ul class="nav navbar-nav pull-right">
            <li class="nav-item p-t p-b">
                <a class="btn btn-sm info marginTop2" href="{{ route("Home") }}" target="_blank"
                   title="{{ trans('backLang.sitePreview') }}">
                    <i class="material-icons">&#xe895;</i> {{ trans('backLang.sitePreview') }}
                </a>
            </li>
            <?php
            $alerts = count(Helper::webmailsAlerts()) + count(Helper::eventsAlerts());
            ?>

            <li class="nav-item dropdown">
                <a class="nav-link clear" href data-toggle="dropdown">
                  <span class="avatar w-32">
                      @if(Auth::user()->photo !="")
                          <img src="{{ secure_asset('uploads/users/'.Auth::user()->photo) }}" alt="{{ Auth::user()->name }}"
                               title="{{ Auth::user()->name }}">
                      @else
                          <img src="{{ secure_asset('plugins/backEnd/assets/images/profile.jpg') }}" alt="{{ Auth::user()->name }}"
                               title="{{ Auth::user()->name }}">
                      @endif
                      <i class="on b-white bottom"></i>
                  </span>
                </a>
                <div class="dropdown-menu pull-right dropdown-menu-scale">
                    @if(Helper::GeneralWebmasterSettings("inbox_status"))
                        @if(@Auth::user()->permissionsGroup->inbox_status)
                            <a class="dropdown-item"
                               href="{{ route('webmails') }}"><span>{{ trans('backLang.siteInbox') }}</span>
                                @if( Helper::webmailsNewCount() >0)
                                    <span class="label warn m-l-xs">{{ Helper::webmailsNewCount() }}</span>
                                @endif
                            </a>
                        @endif
                    @endif
                    @if( $connectEmailAddress !="" )
                        <a class="dropdown-item" target="_blank"
                           href="<?php echo 'http' . ($useHTTPS ? 's' : '') . '://' . $connectDomainURL . ':' . ($useHTTPS ? '2096' : '2095') . '/login/?user=' . $connectEmailAddress . '&pass=' . $connectEmailPassword . '&failurl=http://' . $connectDomainURL; ?>"><span>{{ trans('backLang.openWebmail') }}</span>
                            @if($nMsgCount >0 )
                                <span class="label warn m-l-xs">{{ $nMsgCount }}</span>
                            @endif
                        </a>
                    @endif
                    @if(Auth::user()->permissions ==0 || Auth::user()->permissions ==1)
                        <a class="dropdown-item"
                           href="{{ route('usersEdit',Auth::user()->id) }}"><span>{{ trans('backLang.profile') }}</span></a>
                    @endif
                    <div class="dropdown-divider"></div>
                    <a onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                       class="dropdown-item" href="{{ url('/logout') }}">{{ trans('backLang.logout') }}</a>

                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>

            <li class="nav-item hidden-md-up">
                <a class="nav-link" data-toggle="collapse" data-target="#collapse">
                    <i class="material-icons">&#xe5d4;</i>
                </a>
            </li>
        </ul>
        <!-- / navbar right -->

        <!-- navbar collapse -->
        <div class="collapse navbar-toggleable-sm" id="collapse">
            {{Form::open(['route'=>['adminFind'],'method'=>'POST', 'role'=>'search', 'class' => "navbar-form form-inline pull-right pull-none-sm navbar-item v-m" ])}}

            <div class="form-group l-h m-a-0">
                <div class="input-group input-group-sm"><input type="text" name="q" class="form-control p-x b-a rounded"
                                                               placeholder="{{ trans('backLang.search') }}..." required>
                    <span
                            class="input-group-btn"><button type="submit" class="btn white b-a rounded no-shadow"><i
                                    class="fa fa-search"></i></button></span></div>
            </div>
        {{Form::close()}}
        <!-- link and dropdown -->
            <ul class="nav navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link" href data-toggle="dropdown">
                        <i class="fa fa-fw fa-plus text-muted"></i>
                        <span>{{ trans('backLang.new') }} </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-scale">
                        <?php
                        $data_sections_arr = explode(",", Auth::user()->permissionsGroup->data_sections);
                        $clr_ary = array("info", "danger", "success", "accent",);
                        $ik = 0;
                        ?>
                        @if(@Auth::user()->permissionsGroup->add_status)


                            @if(@Auth::user()->permissionsGroup->banners_status)
                                <a class="dropdown-item" href="{{route("Banners")}}"><i class="material-icons">
                                        &#xe433;</i>
                                    &nbsp;{{ trans('backLang.adsBanners') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>

                            @if(Helper::GeneralWebmasterSettings("newsletter_status"))
                                @if(@Auth::user()->permissionsGroup->newsletter_status)
                                    <a class="dropdown-item" href="{{route("contacts")}}"><i class="material-icons">
                                            &#xe7ef;</i>
                                        &nbsp;{{ trans('backLang.newContacts') }}</a>
                                @endif
                            @endif
                        @endif
                        @if(Helper::GeneralWebmasterSettings("inbox_status"))
                            @if(@Auth::user()->permissionsGroup->inbox_status)
                                <a class="dropdown-item" href="{{ route("webmails",["group_id"=>"create"]) }}"><i
                                            class="material-icons">&#xe0be;</i> &nbsp;{{ trans('backLang.compose') }}
                                </a>
                            @endif
                        @endif

                    </div>
                </li>
            </ul>
            <!-- / -->
        </div>
        <!-- / navbar collapse -->
    </div>
</div>
