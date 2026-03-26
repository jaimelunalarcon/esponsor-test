export const blockSchemas = {
  text: {
    fields: [
      {
        key: 'title',
        type: 'text',
        label: 'Título',
        placeholder: 'Ej: Sobre mí',
        default: '',
      },
      {
        key: 'content',
        type: 'textarea',
        label: 'Contenido',
        placeholder: 'Escribe el contenido del bloque...',
        default: '',
      },
      {
        key: 'backgroundColor',
        type: 'color',
        label: 'Color de fondo',
        default: '#ffffff',
      },
    ],
  },

    social: {
  fields: [
    {
      key: 'instagram',
      type: 'url',
      label: 'Instagram',
      placeholder: 'https://instagram.com/usuario',
      default: '',
    },
    {
      key: 'tiktok',
      type: 'url',
      label: 'TikTok',
      placeholder: 'https://tiktok.com/@usuario',
      default: '',
    },
    {
      key: 'x',
      type: 'url',
      label: 'X',
      placeholder: 'https://x.com/usuario',
      default: '',
    },
    {
      key: 'facebook',
      type: 'url',
      label: 'Facebook',
      placeholder: 'https://facebook.com/usuario',
      default: '',
    },
  ],
},

  image: {
    fields: [
      {
        key: 'image_url',
        type: 'url',
        label: 'URL de la imagen',
        placeholder: 'https://...',
        default: '',
      },
      {
        key: 'alt',
        type: 'text',
        label: 'Texto alt',
        placeholder: 'Describe brevemente la imagen',
        default: '',
      },
    ],
  },

  links: {
    fields: [
        {
        key: 'links',
        type: 'links',
        label: 'Links',
        default: [
            {
            label: '',
            url: '',
            backgroundColor: '#0f172a',
            },
        ],
        },
    ],
  },

  video: {
    fields: [
      {
        key: 'embed_url',
        type: 'url',
        label: 'URL del video',
        placeholder: 'Pega aquí una URL de YouTube',
        default: '',
      },
    ],
  },
}