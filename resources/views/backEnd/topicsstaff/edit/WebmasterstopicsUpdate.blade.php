 <div class="tab-pane  {{ $tab_1 }}" id="tab_details">
                    <div class="box-body">
                        {{Form::open(['route'=>['topicsstaffUpdate',"webmasterId"=>$WebmasterSection->id,"section_id"=>$section_id,"id"=>$Topics->id],'method'=>'POST', 'files' => true])}}



                @include('backEnd.topicsstaff.edit.WebmasterDate')
                @include('backEnd.topicsstaff.edit.Webmasterfacultie_status')
                @include('backEnd.topicsstaff.edit.Webmastersections_status')
                @include('backEnd.topicsstaff.edit.WebmasterContent')
                @include('backEnd.topicsstaff.edit.WebmasterType')
                @include('backEnd.topicsstaff.edit.AdditionalFeilds')

             

                      

                  



                        <div class="form-group row">
                            <label for="link_status"
                                   class="col-sm-2 form-control-label">{!!  trans('backLang.status') !!}</label>
                            <div class="col-sm-10">
                                <div class="radio">
                                    <label class="ui-check ui-check-md">
                                        {!! Form::radio('status','1',($Topics->status==1) ? true : false, array('id' => 'status1','class'=>'has-value')) !!}
                                        <i class="dark-white"></i>
                                        {{ trans('backLang.active') }}
                                    </label>
                                    &nbsp; &nbsp;
                                    <label class="ui-check ui-check-md">
                                        {!! Form::radio('status','0',($Topics->status==0) ? true : false, array('id' => 'status2','class'=>'has-value')) !!}
                                        <i class="dark-white"></i>
                                        {{ trans('backLang.notActive') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row m-t-md">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary m-t"><i class="material-icons">
                                        &#xe31b;</i> {!! trans('backLang.update') !!}</button>
                                <a href="{{ route('topicsstaff',[$WebmasterSection->id,$section_id]) }}"
                                   class="btn btn-default m-t"><i class="material-icons">
                                        &#xe5cd;</i> {!! trans('backLang.cancel') !!}</a>
                            </div>
                        </div>

                        {{Form::close()}}
                    </div>
                </div>