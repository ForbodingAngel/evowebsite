<?php
function shortcode_rss_feed($attributes, $content) {
    $rss_url = isset($attributes['url']) ? $attributes['url'] : $content;
    $limit = isset($attributes['limit']) ? intval($attributes['limit']) : -1; // Default to no limit

    if (empty($rss_url)) {
        return '<p>Error: RSS feed URL missing.</p>';
    }

    // Attempt to load the RSS feed as XML
    $rss = @simplexml_load_file($rss_url);

    if ($rss === false) {
        // If loading fails, attempt to fetch raw content
        $raw_feed = @file_get_contents($rss_url);
        if (!$raw_feed) {
            return '<p>Error loading RSS feed.</p>';
        }
        return parse_raw_rss($raw_feed, $limit);
    }

    return parse_xml_rss($rss, $limit);
}

// Function to parse XML-based RSS feeds
function parse_xml_rss($rss, $limit) {
    $output = '<div class="rss-feed-container">';
    $items = $rss->channel->item;
    $count = 0;

    foreach ($items as $item) {
        if ($limit > 0 && $count >= $limit) {
            break;
        }

        $title = htmlspecialchars((string) $item->title);
        $link = htmlspecialchars((string) $item->link);
        $date = (string) $item->pubDate;
        $description = (string) $item->description; // DO NOT escape to keep HTML

        $image = '';
        // Check if an image exists
        if (isset($item->enclosure['url'])) {
            $image = (string) $item->enclosure['url'];
        } elseif ($item->children('media', true)->content) {
            $image = (string) $item->children('media', true)->content->attributes()->url;
        }

        // Build output
        $output .= '<div class="rss-item">';
        $output .= '<div class="rss-title"><a href="' . $link . '">' . $title . '</a></div>';
        $output .= '<div class="rss-date">' . $date . '</div>';
        if (!empty($image)) {
            $output .= '<div class="rss-image"><img src="' . $image . '" alt="Feed Image"></div>';
        }
        $output .= '<div class="rss-description">' . $description . '</div>'; // Allows HTML
        $output .= '</div>';

        $count++;
    }

    $output .= '</div>';
    return $output;
}

// Function to handle improperly formatted feeds
function parse_raw_rss($raw_feed, $limit) {
    preg_match_all('/(https?:\/\/[^\s]+)(.*?)((?:Mon|Tue|Wed|Thu|Fri|Sat|Sun), \d{2} [A-Za-z]+ \d{4} \d{2}:\d{2}:\d{2} GMT)/', $raw_feed, $matches, PREG_SET_ORDER);
    
    if (empty($matches)) {
        return '<p>Error parsing raw RSS feed.</p>';
    }

    $output = '<div class="rss-feed-container">';
    $count = 0;

    foreach ($matches as $match) {
        if ($limit > 0 && $count >= $limit) {
            break;
        }

        $link = htmlspecialchars($match[1]);
        $title = trim(strip_tags($match[2]));
        $date = htmlspecialchars($match[3]);

        // Extract description properly
        preg_match('/<p>(.*?)<\/p>/s', $raw_feed, $desc_match);
        $description = isset($desc_match[0]) ? $desc_match[0] : '';

        // Attempt to extract an image
        $image = '';
        if (preg_match('/<img[^>]+src=["\'](https?:\/\/[^"\']+)["\']/', $raw_feed, $img_match)) {
            $image = htmlspecialchars($img_match[1]);
        }

        $output .= '<div class="rss-item">';
        $output .= '<div class="rss-title"><a href="' . $link . '">' . $title . '</a></div>';
        $output .= '<div class="rss-date">' . $date . '</div>';
        if (!empty($image)) {
            $output .= '<div class="rss-image"><img src="' . $image . '" alt="Feed Image"></div>';
        }
        $output .= '<div class="rss-description">' . $description . '</div>'; // Allows HTML
        $output .= '</div>';

        $count++;
    }

    $output .= '</div>';
    return $output;
}
?>
