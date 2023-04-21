@php
$_title = get_the_title();
$term_id = 0;
if(!empty($_GET['doc_cat']))
{
$term = get_term_by('slug', $_GET['doc_cat'], 'doc_categories');
if ( ! empty( $term ) && ! is_wp_error( $term ) )
{
$_title = $term->name;
}
$term_id = $term->term_id;
}
@endphp
<div class="staff-visual">
    <div class="container">
        <div class="dots-strip"></div>
        <div class="row justify-content-between">
            <div class="col-lg-6 col-xl-7">
                <div class="text-holder">
                    <h1>{{$_title}}</h1>
                    <p>Take advantage of our library of resources below.</p>
                </div>
            </div>
            <div class="col-lg-6 col-xl-5">
                <div class="image">
                    <img src="{{public_path('images/files_image1.png')}}" alt="image-description">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="staff-section">
    <div class="container">
        <div class="loaderBlock">
            <img src="{{public_path('images/loader.gif')}}">
        </div>
        <div class="search_block">
            <form id="doc-categories-form" name="doc-categories-form" action="{{the_permalink()}}">
                <ul class="list-unstyled form-list">
                    <li>
                        <div class="search-field custom-search">
                            <label>Category</label>
                            <select id="doc_cat" name="doc_cat">
                                <option value="">Please select</option>
                                @if($doc_terms = getDocumentLibraryCategories())
                                    @foreach($doc_terms as $doc_term)
                                        <option value="{{$doc_term->slug}}" @if($doc_term->slug == $_GET['doc_cat']) selected="selected" @endif>{{$doc_term->name}}</option>
                                        {{--@php
                                        $doc_term_children = getTermChildren($doc_term->term_id);
                                        @endphp
                                        @if($doc_term_children)
                                            @foreach($doc_term_children as $doc_term_child)
                                                @if($doc_term_child->term_id != $doc_term->term_id)
                                                    <option value="{{$doc_term_child->slug}}" @if($doc_term_child->slug == $_GET['doc_cat']) selected="selected" @endif>— {{$doc_term_child->name}}</option>
                                                @endif
                                            @endforeach
                                        @endif--}}
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="search-field custom-search">
                            <label>Folder</label>
                            <select id="doc_sub_cat" name="doc_sub_cat">
                                <option value="">Please select</option>
                                @if($term_id > 0)
                                    @php
                                    $term_children = getTermChildren($term_id);
                                    @endphp
                                    @if ( $term_children )
                                        @foreach($term_children as $term_child)
                                            @if($term_child->term_id != $term_id)
                                                <option value="{{$term_child->slug}}" @if($term_child->slug == $_GET['doc_cat']) selected="selected" @endif>{{$term_child->name}}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </select>
                        </div>
                    </li>
                    <li>
                        <div class="search-field">
                            <label>Search</label>
                            <input type="text" name="search_text" placeholder="Search files" class="text-field" value="{{$_GET['search_text']}}">
                        </div>
                    </li>
                    <li>
                        <input type="hidden" name="search_document_library" value="1">
                        <input type="submit" class="submit" value="Search">
                        <a href="#" class="reset_link">Reset Search</a>
                    </li>
                </ul>
                <p><strong>Reminder:</strong> All of the following documents are the property of InHome Therapy. Our Terms of Service forbids the unauthorized distribution of these resources.</p>
            </form>
        </div>
        {{--@if($term_id > 0)
            @php
            $term_children = getTermChildren($term_id);
            @endphp
            @if ( $term_children )
                <ul class="doc-sub-cat">
                    @foreach($term_children as $term_child)
                        @if($term_child->term_id != $term_id)
                            <li><a href="{{home_url('/document-library/') . '?doc_cat=' . $term_child->slug}}" data-slug="{{$term_child->slug}}">{{$term_child->name}}</a></li>
                        @endif
                    @endforeach
                </ul>
            @endif
        @endif--}}
    </div>
</div>