$('.sharing-section').socialSharingPlugin({
    url: $('#data').val(),
    title: $('meta[property="og:title"]').attr('content'),
    description: $('meta[property="og:description"]').attr('content'),
    img: $('meta[property="og:image"]').attr('content'),
    responsive: true,
    mobilePosition: 'left',
    enable: ['copy', 'facebook', 'twitter', 'pinterest', 'linkedin', 'reddit', 'stumbleupon', 'pocket', 'email', 'whatsapp']
})