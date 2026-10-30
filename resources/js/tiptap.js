import { Editor } from '@tiptap/core' /* imports main editor */
import StarterKit from '@tiptap/starter-kit'/* addons for editor */
import { createIcons, icons } from 'lucide'

const editorElement = document.querySelector('#tiptap-editor') /* finds all places where the ditor should be displayed */
const hiddenInput = document.querySelector('#note-content') /* finds hidden inputs to store editors data */

if(editorElement && hiddenInput){
    const editor = new Editor({ /* if a page has both then creates a new editor */
        
        element: editorElement, /* where editor should be rendered */
        extensions: [StarterKit],

        editorProps: {
            attributes: {
                class: 'tiptap',
            },
        },

        content: hiddenInput.value || '<p></p>', /* if previous content, displays it, else empty text block */

        onUpdate: ({ editor }) => {hiddenInput.value = editor.getHTML()}, /* gets editor content and html, saves to hidden input so it can be saved in the Laravel form */


    }) 

    createIcons({ icons })

    document.querySelector('#bold-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleBold().run()
    })

    document.querySelector('#italic-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleItalic().run()
    })

    document.querySelector('#h1-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleHeading({ level: 1 }).run()
    })

    document.querySelector('#h2-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleHeading({ level: 2 }).run()
    })

    document.querySelector('#h3-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleHeading({ level: 3 }).run()
    })

    document.querySelector('#bullet-list-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleBulletList().run()
    })

    document.querySelector('#ordered-list-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleOrderedList().run()
    })

    document.querySelector('#code-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleCode().run()
    })

    document.querySelector('#undo-button')?.addEventListener('click', () => {
        editor.chain().focus().undo().run()
    })

    document.querySelector('#redo-button')?.addEventListener('click', () => {
        editor.chain().focus().redo().run()
    })

    const updateToolbarState = () => {
        document.querySelector('#bold-button')
            ?.classList.toggle('is-active', editor.isActive('bold'))

        document.querySelector('#italic-button')
            ?.classList.toggle('is-active', editor.isActive('italic'))

        document.querySelector('#h1-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('heading', { level: 1 })
            )

        document.querySelector('#h2-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('heading', { level: 2 })
            )

        document.querySelector('#h3-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('heading', { level: 3 })
            )

        document.querySelector('#bullet-list-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('bulletList')
            )

        document.querySelector('#ordered-list-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('orderedList')
            )

        document.querySelector('#code-button')
            ?.classList.toggle(
                'is-active',
                editor.isActive('code')
            )

    }

editor.on('selectionUpdate', () => {
    updateToolbarState()
})

editor.on('transaction', () => {
    updateToolbarState()
})

updateToolbarState()
    
}
