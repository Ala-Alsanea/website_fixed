   <?php
   // Current Full URL
   $fullPagePath = Request::url();
   // Char Count of Backend folder Plus 1
   $envAdminCharCount = strlen(env('BACKEND_PATH')) + 1;
   // URL after Root Path EX: admin/home
   $urlAfterRoot = substr($fullPagePath, strpos($fullPagePath, env('BACKEND_PATH')) + $envAdminCharCount);
   ?>
   <?php
   $category_title_var = 'title_' . trans('backLang.boxCode');
   $slug_var = 'seo_url_slug_' . trans('backLang.boxCode');
   $slug_var2 = 'seo_url_slug_' . trans('backLang.boxCodeOther');
   $link_title_var = 'title_' . trans('backLang.boxCode');
   $title_var = 'title_' . trans('backLang.boxCode');
   $title_var2 = 'title_' . trans('backLang.boxCodeOther');
   $details_var = 'details_' . trans('backLang.boxCode');
   $details_var2 = 'details_' . trans('backLang.boxCodeOther');
   $BannerMenu = 'Banner_menu_about';
   ?>
   <!-- LOGO AND MENU SECTION -->
   <style type="text/css">
       .wed-logo1 img {
           margin-top: 10px;
       }
   </style>
   <div class="top-logo" data-spy="affix" data-offset-top="250">
       <div class="container">
           <div class="row">
               <div class="col-md-3 no-padding">
                   <div class="wed-logo1" dir="{{ trans('backLang.direction') }}">
                       <a class="logo" href="{{ route('Home') }}">
                           @if (Helper::GeneralSiteSettings('style_logo_' . trans('backLang.boxCode')) != '')
                               {{--  <img src="{{secure_asset('uploads/logo11.png') }}"> --}}
                               <img alt=""
                                   src="{{ Helper::FilterImage(Helper::GeneralSiteSettings('style_logo_' . trans('backLang.boxCode'))) }}"
                                   srcset="{{ Helper::FilterImage(Helper::GeneralSiteSettings('style_logo_' . trans('backLang.boxCode'))) }}"
                                   class="wed-logo-section">
                           @else
                               <img alt="" src="{{ secure_asset('uploads/settings/nologo.png') }}"
                                   srcset="{{ secure_asset('uploads/settings/nologo.png') }}" class="wed-logo-section">
                           @endif
                       </a>

                   </div>
               </div>
               <div class="col-md-9 no-padding">
                   <div class="main-menu " style="width:100%">
                       <ul>

                           @foreach ($HeaderMenuLinks as $key => $HeaderMenuLink)
                               @if ($HeaderMenuLink->father_id == 1)
                                   <?php
                                   $BannerMenu = 'Banner_menu_' . $HeaderMenuLink->link;
                                   ?>
                                   <li class="{!! $HeaderMenuLink->link !!}-menu">
                                       <a href="#" class="mm-arr">
                                           <i class="fa  {!! $key == 0 ? 'fa-th' : '' !!}" style='padding: 3px;'>
                                           </i>
                                           {{ $HeaderMenuLink->$link_title_var }}
                                       </a>


                                       <div class="mm-pos">
                                           <div class="{!! $HeaderMenuLink->link !!}-mm m-menu">
                                               <div class="m-menu-inn row">
                                                   <?php
                                                   $count = $HeaderMenuLink->subMenus->count();
                                                   $col = 3;
                                                   if ($count <= 2) {
                                                       $col = 4;
                                                   }

                                                   ?>
                                                   <div
                                                       class="mm1-com mm1-s1 col-xl-{{ $col }} col-lg-{{ $col }} col-md-{{ $col }} col-sm-6 col-xs-12 ">
                                                       <div class="ed-course-in">
                                                           <a class="course-overlay menu-{!! $HeaderMenuLink->link !!}"
                                                               href="#">
                                                               <img src="{{ Helper::getBannerStatic($BannerMenu) }}"
                                                                   style="box-shadow: 0px 7px 12px -4px rgba(0, 0, 0, 0.45);">

                                                           </a>
                                                       </div>
                                                   </div>
                                                   @foreach ($HeaderMenuLink->subMenus as $subMenus)
                                                       @if ($subMenus->status == 1)
                                                           <div
                                                               class="mm1-com mm1-s{{ $col }} col-xl-{{ $col }} col-lg-{{ $col }} col-md-{{ $col }} col-sm-6 col-xs-12">



                                                               <h4 class="m-header">{{ $subMenus->$link_title_var }}
                                                               </h4>

                                                               <ul>
                                                                   @if ($subMenus->type == 1)
                                                                       <?php
                                                                       $namesection = 'faculties';
                                                                       $endlenk = '/home';

                                                                       if ($subMenus->link == 'programs') {
                                                                           $endlenk = '';
                                                                           $MenuSectionCustoms = App\Models\Program::where('status', 1)->get();
                                                                       } else {
                                                                           $MenuSectionCustoms = App\Models\Faculty::where('status', 1)->get();
                                                                       }

                                                                       $namesection = $subMenus->link;

                                                                       ?>


                                                                       @if (count($MenuSectionCustoms->toArray()) > 0)
                                                                           @foreach ($MenuSectionCustoms as $MenuSectionCustom)
                                                                               <?php
                                                                               $MenuSectionCustom_link_url = url(trans('backLang.code') . '/' . $MenuSectionCustom->url_link);
                                                                               if ($MenuSectionCustom->$slug_var != '' && Helper::GeneralWebmasterSettings('links_status')) {
                                                                                   if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                                                                       $MenuSectionCustom_link_url = url(trans('backLang.code') . '/' . $MenuSectionCustom->$slug_var);
                                                                                   } else {
                                                                                       $MenuSectionCustom_link_url = url($MenuSectionCustom->$slug_var);
                                                                                   }
                                                                               }
                                                                               ?>



                                                                               <li><a
                                                                                       href="{{ url(trans('backLang.code') . '/' . $namesection . '/' . $MenuSectionCustom->id) . $endlenk }}">{{ $MenuSectionCustom->$title_var }}</a>
                                                                               </li>
                                                                           @endforeach
                                                                       @endif
                                                                   @elseif($subMenus->type == 3)
                                                                       @if (count($subMenus->webmasterSection->sections) > 0)
                                                                           @foreach ($subMenus->webmasterSection->sections as $SubMnuCategory)
                                                                               @if ($SubMnuCategory->father_id == 0 && $SubMnuCategory->status == 1)
                                                                                   <?php

                                                                                   $Category_link_url1 = url($SubMnuCategory->section_url == '' ? '#' : trans('backLang.code') . '/' . $SubMnuCategory->section_url);
                                                                                   if ($SubMnuCategory->$slug_var != '' && Helper::GeneralWebmasterSettings('links_status')) {
                                                                                       if (trans('backLang.code') != env('DEFAULT_LANGUAGE')) {
                                                                                           $Category_link_url1 = url(trans('backLang.code') . '/' . $SubMnuCategory->$slug_var);
                                                                                       } else {
                                                                                           $Category_link_url1 = url($SubMnuCategory->$slug_var);
                                                                                       }
                                                                                   }
                                                                                   ?>
                                                                                   <li><a
                                                                                           href="{{ $Category_link_url1 }}">
                                                                                           {{ $SubMnuCategory->$title_var }}</a>
                                                                                   </li>
                                                                               @endif
                                                                           @endforeach
                                                                       @endif
                                                                   @else
                                                                       @foreach ($subMenus->subMenus as $keys => $subMenusFilnal)
                                                                           @if ($subMenusFilnal->status == 1)
                                                                               @if ($HeaderMenuLink->link == 'admi' && $keys == $subMenus->subMenus->count() - 1)
                                                                                   <li><a class="mm-r-m-btn-cust btn_m"
                                                                                           href="{{ url(trans('backLang.code') . '/' . $subMenusFilnal->link) }}">{{ $subMenusFilnal->$link_title_var }}</a>
                                                                                   </li>
                                                                               @else
                                                                                   <li><a
                                                                                           href="{{ url(trans('backLang.code') . '/' . $subMenusFilnal->link) }}">{{ $subMenusFilnal->$link_title_var }}</a>
                                                                                   </li>
                                                                               @endif
                                                                           @endif
                                                                       @endforeach
                                                                   @endif

                                                               </ul>
                                                           </div>
                                                       @endif
                                                   @endforeach

                                               </div>
                                           </div>
                                       </div>
                               @endif
                           @endforeach



                           </li>

                           <li>
                               @if ($WebmasterSettings->languages_count == 2)

                                   <strong>
                                       @if (trans('backLang.code') == 'ar')
                                           <a href="{{ url(Helper::ChangeUrl('en')) }}" class="language"><i
                                                   class="fa fa-language "></i>
                                               {{ str_replace('[ ', '', str_replace(' ]', '', strip_tags(trans('backLang.englishBox')))) }}
                                           </a>
                                       @else
                                           <a href="{{ url(Helper::ChangeUrl('ar')) }}" class="language"><i
                                                   class="fa fa-language "></i>
                                               {{ str_replace('[ ', '', str_replace(' ]', '', strip_tags(trans('backLang.arabicBox')))) }}
                                           </a>
                                       @endif

                                   </strong>
                               @endif

                           </li>

                           {{--    <li><span class="navbar-text"><i id='morex' class="more fa fal fa-th " aria-hidden="true" title="Quick Menu" style="color: #000;"></i><span class="sr-only">Quick Menu</span></span>

    </li> --}}



                       </ul>

                   </div>

               </div>

               {{-- <div class="all-drop-down-menu">

        <div class="mega-menu2" style="display:none;">

        @include('frontEnd.includes.Quick-Menu')

        </div>
    </div> --}}

           </div>
       </div>
   </div>
