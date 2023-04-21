<div class="data-holder">
    <div class="data-head">
        <h2>{{the_title()}}</h2>
        <ul class="list-unstyled">
            <li class="doc">
                <span class="title">Documentation: </span>
                <span class="text">{!! get_field('agency_documentation') !!}</span>
            </li>
        </ul>
    </div>
    <div class="data-description">
        <h2>{{ get_field('agency_iht_customer_service') }}</h2>
        <div class="holder">
            <ul class="list-unstyled">
                <li class="location">
                    <span class="title">Location: </span>
                    <span class="text"> {{ get_field('agency_location') }} </span>
                </li>
                <li class="phone">
                    <div class="description">
                        <span class="title">Phone:</span>
                        <span class="text"><a href="tel:{{ preg_replace("/[^0-9]/", "", get_field('agency_phone')) }}">{{ get_field('agency_phone') }}</a></span>
                    </div>
                    @if(!empty(get_field('agency_phone_ext')))
                    <div class="description">
                        <span class="title">Ext: </span>
                        <span class="text">{{get_field('agency_phone_ext')}}</span>
                    </div>
                    @endif
                </li>
                <li class="fax">
                    <span class="title">Fax: </span>
                    <span class="text"> {{get_field('agency_fax')}} </span>
                </li>
            </ul>
            <ul class="list-unstyled">
                <li class="position">
                    <span class="title">Position:  </span>
                    <span class="text"> {{get_field('agency_position')}} </span>
                </li>
                <li class="email">
                    <span class="title">Email:</span>
                    <span class="text"> <a href="mailto:{{get_field('agency_email')}}">{{get_field('agency_email')}}</a> 
						@if(get_field('email2'))
						<a href="mailto:{{get_field('email2')}}" style=" margin-left: 50px">{{get_field('email2')}}</a>
						@endif
					</span>
                </li>
                @if(!empty(get_field('agency_cell')))
                <li class="phone">
                    <div class="description">
                        <span class="title">Cell: </span>
                        <span class="text"><a href="tel:{{ preg_replace("/[^0-9]/", "", get_field('agency_cell')) }}">{{ get_field('agency_cell') }}</a></span>
                    </div>
                </li>
                @endif
                
                @if(!empty(get_field('medicare_week')))
                <li class="med">
                    <div class="description">
                        <span class="title">Medicare Week: </span>
                        <span class="text">{{ get_field('medicare_week') }}</span>
                    </div>
                </li>
                @endif
                
                @if(!empty(get_field('where_to_collect_signature')))
                <li class="sig">
                    <div class="description">
                        <span class="title">Where to Collect Signature: </span>
                        <span class="text">{{ get_field('where_to_collect_signature') }}</span>
                    </div>
                </li>
                @endif
                
                
            </ul>
        </div>
    </div>
</div>