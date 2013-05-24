<div id="exerplan-gallery-item-[[+exerplan.gallery.id]]">
    [[+exerplan.gallery.url:notempty=`
    <div>
        <a href="[[+exerplan.gallery.url]]"
           title="[[+exerplan.gallery.description]]"
           class="lightbox">
            [[+exerplan.gallery.name]]
        </a>
    </div>
    `:default=`
    <div>[[+exerplan.gallery.name]]</div>
    `]]
    <div>[[+exerplan.gallery.description]]</div>
</div>