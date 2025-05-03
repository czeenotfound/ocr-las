# OCR-Library Attendance System (OCR-LAS)

## Overview
OCR-Library Attendance System (OCR-LAS) is a software solution developed by SURV Co. that uses Optical Character Recognition (OCR) technology to automate library attendance tracking. The system is designed to streamline the process of recording student attendance in libraries using modern technology.

## Developers
SURV Co. Team Members:
- Sanguila, Mary Joy
- Undo, Khalil M.
- Rodrigo, Jondino
- Vergara, Kayce

## Features
- Real-time OCR processing using Tesseract.js
- Webcam integration for ID scanning
- Automated attendance tracking
- User-friendly interface
- Admin dashboard for system management
- Secure database storage

## Technology Stack
- Frontend: HTML, CSS, JavaScript
- Backend: PHP
- Database: MySQL
- OCR Engine: Tesseract.js
- Additional Libraries: Composer for dependency management

## Prerequisites
- XAMPP (Apache and MySQL)
- PHP 7.4 or higher
- Web browser with webcam support
- Composer (PHP package manager)

## Installation
1. Clone the repository to your XAMPP's htdocs directory:
   ```bash
   git clone [repository-url] OCR-LAS
   ```

2. Navigate to the project directory and install dependencies:
   ```bash
   composer install
   ```

3. Configure your database:
   - Create a new MySQL database named 'ocrlasdb1'
   - Update database credentials in `app/configdb/constants.php` if needed
   - Default configuration:
     - Host: localhost
     - User: root
     - Password: (empty)
     - Database: ocrlasdb1

4. Start your XAMPP Apache and MySQL services

5. Access the application through your web browser:
   ```
   http://localhost/OCR-LAS
   ```

## Usage
1. Start the system and allow camera access when prompted
2. Position student ID within the scanning area
3. The system will automatically detect and process the ID number
4. Attendance is recorded in the database automatically

## Security
- The system implements secure session management
- Database credentials are stored in configuration files
- Input validation and sanitization are implemented

## Support
For technical support or questions, please contact the development team at SURV Co.

## License
Copyright © 2024 SURV Co. - All Rights Reserved

This project was developed as part of IT 132 - Software Engineering. 