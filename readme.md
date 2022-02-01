## Instructions to use
- `[cwremote_frontend]` shortcode for AJAX enabled fetching.
- `[cwremote_noajax]` shortcode for no AJAX
- `CWRemote admin menu` can be used to fetch data. By default it is not set to fetch new data, but can be adjusted by fetching the data once before display.
## Notes
> This plugin includes a lot of hooks that help customize things further. I have not written a documentation for these as it is not part of the scope, but can be documented if needed.

`lib/Validation.php` - This class can be used to further validate and sanitize the data before storage. 