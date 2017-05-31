Facebook Comments
=================

The "Facebook Comments" extension inserts a Facebook comment thread in your 
templates. Use it by simply placing the following in your template:

    {{ facebookcomments() }}

To include a record's link, pass it as a parameter:

    {{ facebookcomments(record.link) }}
    
To show comments number including the link, use the following:

    {{ facebookcommentslink(record.link) }}

