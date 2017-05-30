Facebook Comments
=================

The "Facebook Comments" extension inserts a Facebook comment thread
in your templates. Use it by simply placing the following in your template:

    {{ facebookcomments() }}

To include the any record's link, pass it as a parameter:

    {{ facebookcomments( record.link ) }}
    
To show comments number and its link, pass it as a parameter:

    {{ facebookcommentslink( record.link ) }}

