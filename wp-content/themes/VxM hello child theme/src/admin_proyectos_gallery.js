jQuery(function ($) {
  // Define frame variable outside the click handler
  var frame;

  // Use body delegation so it works even if the meta box HTML updates via AJAX
  $("body").on("click", ".proyectos-gallery-add", function (e) {
    e.preventDefault();

    // 1. Always find the input and preview container FRESHLY from the DOM
    // (Do not store these in variables outside the events)
    var $inputField = $("#proyectos_gallery_input");
    var $previewDiv = $("#proyectos_gallery_preview");

    // 2. Re-open existing frame if available
    if (frame) {
      frame.open();
      return;
    }

    // 3. Create media frame
    frame = wp.media({
      title: "Seleccionar imágenes de la galería",
      button: { text: "Usar estas imágenes" },
      multiple: true,
    });

    // 4. When frame opens, select existing images
    frame.on("open", function () {
      var currentIds = $("#proyectos_gallery_input").val(); // Get fresh value
      var selection = frame.state().get("selection");

      if (!currentIds) return;

      currentIds.split(",").forEach(function (id) {
        var attachmentId = parseInt(id, 10);
        if (attachmentId) {
          var attachment = wp.media.attachment(attachmentId);
          attachment.fetch();
          selection.add(attachment ? attachment : null);
        }
      });
    });

    // 5. When images are selected (The 'Insert' or 'Use' button is clicked)
    frame.on("select", function () {
      var selection = frame.state().get("selection");
      var ids = [];
      var html = "";

      selection.each(function (attachment) {
        attachment = attachment.toJSON();
        ids.push(attachment.id);

        // Handle image sizes safely (fallback to full URL if thumb doesn't exist)
        var thumbUrl =
          attachment.sizes && attachment.sizes.thumbnail
            ? attachment.sizes.thumbnail.url
            : attachment.url;

        html +=
          '<div class="gallery-item" style="width:80px; height:80px; margin:5px; background:#eee; border:1px solid #ccc; display:inline-block;">';
        html +=
          '<img src="' +
          thumbUrl +
          '" style="width:100%; height:100%; object-fit:cover;" />';
        html += "</div>";
      });

      // UPDATE THE DOM
      // We re-select the elements here to be 100% safe
      $("#proyectos_gallery_input").val(ids.join(","));

      // CRITICAL: Trigger change so Gutenberg/WordPress knows to enable the "Update" button
      $("#proyectos_gallery_input").trigger("change");

      $("#proyectos_gallery_preview").html(html);
    });

    frame.open();
  });
});
