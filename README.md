# Plugin Name 
**Contributors:** laith3  
**Tags:** projects portfolio, filterable portfolio, portfolio, portfolio gallery, Responsive Portfolio, animated portfolio grid, hover effect with lightbox  
**Requires at least:** 4.1.1  
**Tested up to:** 4.6.1  
**Stable tag:** trunk  
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  

Create portfolio in nice grid format that is animated and filterable with beautiful hover overlay of project title and description.


## Description 

### Plugin Features:

* Responsive Portfolio Grid
* Category Filtering with Animation
* Beautiful Overlay on Hover with Project Title and Description
* Lightbox Popups
* Drag/Drop Sort to Quickly Reorder Portfolio Items
* Shortcode Support with several options
* Set Crop Width and Height
* Set Number of Columns - 2, 3, or 4 Columns
* Simple and Intuitive Interface for Quick Portfolio Setup
* Hide Category Filters (both globally and per instance via shortcode)
* **New** - Specify number of posts via shortcode


**[Plugin Demo](http://www.sinawiwebdesign.com/wordpress-plugins/fancy-grid-portfolio/)**


* Credits: MixItUp, Lightbox2, jQuery


## Installation 

1. Add plugin to the /wp-content/plugins/ directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create Portfolio.
1. Add shortCode `[fgp_portfolio]` to page or post to display the Portfolio.


### Usage

1. Add Portfolio Items - Title, Description, Image and Category(s)
1. Create page, menu item and include shortcode in page	`[fgp_portfolio]`
1. You can override "Hide Filter Categories" setting in shortcode by using "hide_filters" attribute (see example below)
1. Reorder your portfolio items using Drag and Drop Sort

Shortcode Options: hide_filters, count, num_columns

Shortcode examples:

1. `[fgp_portfolio hide_filters=1]` (hide filters)
1. `[fgp_portfolio count=3 num_columns=3 hide_filters=1]` (limit to 3 posts to showcase Recent Work)


## Frequently Asked Questions 


### How can I change portfolio number of column? 

Go to Grid Portfolio -> Dashboard and look under Plugin Options section for Number of Columns setting. Or you can set number of column per instance via shshortcode by using parameter num_columns.  Example: `[fgp_portfolio num_columns=2]`


### Why is my portfolio grid showing different size images? 

You should upload images and not use existing ones from the media library for your portfolio in order for the crop to work.  Then your images will all be the same size and the grid will be consistent.


## Screenshots 

### 1. Fancy Grid Portfolio grid display on front end
![Fancy Grid Portfolio grid display on front end](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-1.png)

### 2. Fancy Grid Portfolio quick view popup.
![Fancy Grid Portfolio quick view popup.](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-2.png)

### 3. Fancy Grid Portfolio options
![Fancy Grid Portfolio options](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-3.png)

### 4. Fancy Grid Portfolio drag-drop sort
![Fancy Grid Portfolio drag-drop sort](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-4.png)

### 5. Fancy Grid Portfolio custom post type view
![Fancy Grid Portfolio custom post type view](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-5.png)

### 6. Fancy Grid Portfolio custom taxonomy view
![Fancy Grid Portfolio custom taxonomy view](https://ps.w.org/fancy-grid-portfolio/assets/screenshot-6.png)



## Changelog 

### version 2.0.1
Tested on WordPress version 4.7.1
Added CSS namespace for description overlay color getting overwritten by some theme's CSS

### version 2.0 
* Complete new code base - change from procedure programming to object oriented programming using WordPress best practises.
* New feature - added shortcode option to specify number of posts
* Bug fix - featured image not displaying over https in admin
* Bug fix - drag drop reorder admin not displaying correct order


### version 1.1.0 
* New feature - added Hide Category Filters (both globally and per instance via shortcode)


### version 1.0 
* Initial release


## Upgrade Notice 

### 2.0.1
Tested on WordPress 4.7 and minor bug fix - see Changelog

### 2.0 
Bug fixes and new features - see changelog