<div class="mb-3 flex flex-wrap gap-2">

    <button type="button" id="bold-button" class="toolbar-button" title="Bold"><i data-lucide="bold"></i></button>
    <button type="button" id="italic-button" class="toolbar-button" title="Italic"><i data-lucide="italic"></i></button>
    <button type="button" id="h1-button" class="toolbar-button" title="Heading 1"><i data-lucide="heading-1"></i></button>
    <button type="button" id="h2-button" class="toolbar-button" title="Heading 2"><i data-lucide="heading-2"></i></button>
    <button type="button" id="h3-button" class="toolbar-button" title="Heading 3"><i data-lucide="heading-3"></i></button>
    <button type="button" id="bullet-list-button" class="toolbar-button" title="Bullet list"><i data-lucide="list"></i></button>
    <button type="button" id="ordered-list-button" class="toolbar-button" title="Ordered list"><i data-lucide="list-ordered"></i></button>
    <button type="button" id="code-button" class="toolbar-button" title="Code"><i data-lucide="code"></i></button>
    <button type="button" id="undo-button" class="toolbar-button" title="Undo"><i data-lucide="undo-2"></i></button>
    <button type="button" id="redo-button" class="toolbar-button" title="Redo"><i data-lucide="redo-2"></i></button>

</div>

<div>


        <div id="tiptap-editor"></div>

        <input
            type="hidden"
            id="note-content"
            name="content"
            value="{{ $content ?? '' }}">
    
</div>