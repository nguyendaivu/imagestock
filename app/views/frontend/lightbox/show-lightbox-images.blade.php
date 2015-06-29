@if (Auth::user()->check())


    <div id="lightbox">
        <h1><span>Lightbox {{ $lightboxName }}</span></h1>
        <div style="text-align:right"><a id="lightbox-back" href="#" onClick="backToLightbox()">Back to lightboxes</a></div>
        <hr />    
        <p>
            @if(isset($arrlightboxImages) && count($arrlightboxImages)>0)
                @foreach($arrlightboxImages as $lightboxImage)
                    @if (isset($lightboxImage['path'])) 
                    <div style="display:inline-block">                      
                        <div style="display:inline;"><a id="lightbox-revmove" href="#" onClick="removeLightboxImages(event, '{{ $lightboxImage['id'] }}')"><img src="{{URL}}/assets/global/img/remove-icon-small.png" width="10px" /></a></div>
                        
                        <div style="display:inline;">
                            <div><a rel="example_group" href="{{URL}}{{ $lightboxImage['path'] }}"><img alt="" src="{{URL}}{{ $lightboxImage['path'] }}" width="100px" /></a></div>
                            
                            <div id="div-lightbox-name" style="padding-top:15px" onclick="lightboxDetail('{{ $lightboxImage['id'] }}')"><a href="{{URL}}/pic-{{$lightboxImage['image_id']}}/{{$lightboxImage['short_name']}}.html">{{$lightboxImage['name']}}</a></div>
                            
                        </div>
                    </div>
                    @endif
                @endforeach            	
            @endif
    
        </p>    
    </div>

@endif   