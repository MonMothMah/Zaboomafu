# Bookmarklet Hub - PHP Platform

A comprehensive bookmarklet platform built with PHP that allows users to discover, install, and rate useful bookmarklets. The platform features a modern responsive design and includes both a frontend for users and a backend for administration.

## Features

### Frontend Features
- **Responsive Design**: Modern, mobile-friendly interface using CSS Grid and Flexbox
- **Bookmarklet Discovery**: Browse bookmarklets by category, rating, popularity, and search
- **Rating System**: Users can rate bookmarklets on a 5-star scale (1 vote per IP)
- **Detailed Pages**: Individual pages for each bookmarklet with description and installation instructions
- **Category System**: Organized bookmarklets by categories
- **Search & Filter**: Advanced search with multiple filter and sort options
- **Installation Guide**: Detailed instructions on how to install bookmarklets

### Backend Features
- **Secure Admin Panel**: Password-protected admin area with session management
- **Bookmarklet Management**: Create, edit, and delete bookmarklets
- **Category Management**: Add, edit, and delete categories
- **Settings Management**: Configure site title, description, and other settings
- **Statistics**: View site metrics and bookmarklet performance

## Installation

1. Upload all files to your web server
2. Ensure the `data/` directory has write permissions (755 or 777)
3. Access your site through a web browser
4. Use the default admin credentials to access the admin panel:
   - Username: `admin`
   - Password: `your_secure_password_here` (change this in config.php)

## Security

- Passwords are hashed using PHP's password_hash() function
- IP-based rating restrictions to prevent multiple votes
- Session-based admin authentication
- Input validation and sanitization
- File access restrictions for sensitive data

## Customization

- Update site settings in the admin panel
- Modify the CSS in `/css/style.css` to change the appearance
- Add custom JavaScript in `/js/main.js` for additional functionality

## Directory Structure

```
/workspace/
├── index.php          # Main entry point
├── config.php         # Configuration file
├── includes/
│   └── functions.php  # Core functions
├── css/
│   └── style.css      # Main stylesheet
├── js/
│   └── main.js        # JavaScript functionality
├── data/              # Data storage (JSON files)
├── pages/             # Frontend pages
├── admin/             # Admin panel
└── .htaccess          # Apache configuration
```

## Admin Credentials

Default admin login:
- Username: `admin`
- Password: `your_secure_password_here`

**Important**: Change the default password in `config.php` after installation.

## URL Structure

- Homepage: `?page=home` or `/`
- Individual bookmarklet: `?page=bookmarklet&id=X`
- Category page: `?page=category&name=category-name`
- Search page: `?page=search`
- Installation guide: `?page=install`
- Admin panel: `?page=admin`

## SEO Features

- Clean URLs with .htaccess rewrite rules
- Meta tags for each page
- Semantic HTML structure
- Proper heading hierarchy

## Data Storage

The platform uses flat-file JSON storage for simplicity:
- `data/bookmarklets.json` - All bookmarklet data
- `data/categories.json` - Category information
- `data/settings.json` - Site settings
- `data/ratings.json` - User ratings (by IP)
- `data/users.json` - User information (empty by default)

## Adding Bookmarklets

To add a new bookmarklet:
1. Log into the admin panel
2. Go to "Manage Bookmarklets"
3. Click "Add New"
4. Fill in the details:
   - Title: Name of the bookmarklet
   - Description: What the bookmarklet does
   - Code: The JavaScript code starting with "javascript:"
   - Category: Select from existing categories
   - Active: Whether it's visible on the site

## Contributing

Feel free to fork this repository and submit pull requests for improvements.

## License

This project is open source and available under the MIT License.