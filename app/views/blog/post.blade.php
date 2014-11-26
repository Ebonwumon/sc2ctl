<section class="blog" data-bid="{{$blog->id}}">
	<header class="blog-header">
		<h2 class="blog-title">
			<a href="{{ URL::route('blog.profile', $blog->id) }}">
				{{ $blog->title }}
			</a>
		</h2>
		<img class="blog-avatar" src="{{ $blog->user->img_url }}" />
		<p class="blog-meta">
			By 
			<a href="{{ URL::route('user.show', $blog->user->id) }}" class="blog-author">
				{{ $blog->user->username }}
			</a>
			in
			@foreach ($blog->categories as $category) 
				<a class="blog-category blog-category-{{$category->name}}">{{$category->name}}</a>
			@endforeach
		</p>
	</header>
	<div class="blog-content">
		{{ $blog->content }}
	</div>
</sction>
