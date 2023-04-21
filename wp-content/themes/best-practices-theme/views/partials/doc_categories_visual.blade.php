<div class="staff-visual">
	<div class="container">
		<div class="dots-strip"></div>
		<div class="row justify-content-between">
			<div class="col-lg-6 col-xl-7">
				<div class="text-holder">
					<h1>{{$term->name}}</h1>
					<p>{{$term->description}}</p>
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
		<div class="search_block">
			<form id="doc-categories-form" name="doc-categories-form" action="{{$current_page_url}}">
				<ul class="list-unstyled form-list">
					
					<li>
						<div class="search-field custom-search">
							<label>Category</label>
							<select>
								<option>TNR</option>
								<option>HEP</option>
								<option>TNR</option>
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
						<input type="hidden" name="search_doc_categories" value="1">
						<input type="submit" class="submit" value="Search">
					</li>
				</ul>
				<p><strong>Reminder:</strong> All of the following documents are the property of InHome Therapy. Our Terms of Service forbids the unauthorized distribution of these resources.</p>
			</form>
		</div>
	</div>
</div>