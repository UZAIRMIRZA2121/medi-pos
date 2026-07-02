# MediPOS - Store Setup Guide

This guide will walk you through setting up the MediPOS system on a brand new computer. 

## 📦 Required Software
Before installing the POS, you need to download and install these three free tools:

1. **XAMPP** (with PHP 8.2 or higher)
   - Download: [apachefriends.org](https://www.apachefriends.org/download.html)
   - *Install it in the default `C:\xampp` folder.*
2. **Composer** (PHP Package Manager)
   - Download: [getcomposer.org](https://getcomposer.org/download/)
   - *Run the installer and just click "Next" until finished.*
3. **Node.js** (For frontend assets)
   - Download: [nodejs.org](https://nodejs.org/)

---

## 🛠️ Step-by-Step Installation

### Step 1: Copy the Project
1. Copy the entire `medi-pos` folder onto a USB drive.
2. On the new computer, paste the `medi-pos` folder into: `C:\xampp\htdocs\`

### Step 2: Install Dependencies
1. Open the `medi-pos` folder.
2. Click on the address bar at the top of the folder window, type `cmd`, and press Enter. This will open a black terminal window.
3. Type the following commands one by one, pressing Enter after each:
   ```bash
   composer install
   npm install
   npm run build
   ```

### Step 3: Database Setup
1. Open XAMPP Control Panel and start **Apache** and **MySQL**.
2. Go to your browser and open `http://localhost/phpmyadmin`
3. Click **"New"** on the left sidebar and create a database named: `medi_pos`
4. Go back to your `cmd` terminal and run:
   ```bash
   php artisan migrate
   ```

### Step 4: Configure Live Sync (Optional)
If you want this new store to sync with the live server:
1. Open the `.env` file inside the `medi-pos` folder (using Notepad).
2. Change the API URL to your live server:
   ```env
   CLOUD_API_URL=https://your-live-domain.com/api
   ```

---

## 🚀 How to Run the Software (Daily Use)

You don't need to manually start XAMPP or the terminal every day! I've created a 1-click launcher for you.

1. Go inside the `medi-pos` folder.
2. Right-click on **`MediPOS.vbs`** -> Select **"Send to"** -> **"Desktop (create shortcut)"**.
3. Now, you have an app icon on your desktop!

Whenever you want to use the POS, just **double-click the MediPOS desktop icon**. 
- It will automatically spin up the database in the background.
- It will automatically launch the web server.
- It will automatically launch the Background Auto-Sync system.
- It will open the POS in a clean, full-screen App window.

To close the background servers completely at the end of the day, you can double-click **`Stop-MediPOS.bat`**.
