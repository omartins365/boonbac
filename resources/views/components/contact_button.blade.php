   <div class="card p-2 my-2">
       {{-- <h4 class="p-2 lead">{{ $title ?? 'Contact '.$brand }}</h4> --}}
       <div @class([
           'd-grid' => isset($aside),
           'gap-2',
           'justify-content-around' => !isset($aside),
           'd-flex' => !isset($aside),
       ])>
           @isset($aside)
               <img src="{{ @$agent?->pic_url() }}" class="img-fluid img-responsive py-md-3 mx-auto"
                   alt="{{ @$agent?->brand_name ?? 'AGENT' }}">
           @endisset
           <button class="btn btn-real" type="button" data-bs-target="#contactModalToggle" data-bs-toggle="modal"><i
                   class="fas fa-phone"></i> Call Martins</button>
           <div class="">
               <div class="d-flex justify-content-between">
                   <a href="https://wa.me/{{ Str::of($agent->wa_phone??"")->replace('+', '') }}?text=Hello+{{ $agent->brand_name?? "Martins" }}" class="btn btn-success col me-2" type="button"><i class="fab fa-whatsapp"></i></a>
                   <button class="btn btn-dark col-9" type="button" data-bs-toggle="offcanvas"
                       data-bs-target="#was_canvas" aria-controls="was_canvas"><i class="fas fa-paper-plane"></i> Chat with me</button>
               </div>
           </div>
       </div>
   </div>
