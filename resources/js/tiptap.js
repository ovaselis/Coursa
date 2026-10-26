import { Editor } from '@tiptap/core' /* imports main editor */
import StarterKit from '@tiptap/starter-kit'/* addons for editor */


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

    document.querySelector('#bold-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleBold().run()
    })

    document.querySelector('#italic-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleItalic().run()
    })

    document.querySelector('#h1-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleHeading({ level: 1 }).run()
    })

    document.querySelector('#bullet-list-button')?.addEventListener('click', () => {
        editor.chain().focus().toggleBulletList().run()
    })

}