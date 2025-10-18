# WASTE NO MORE - NVAT Waste Management System

A comprehensive Laravel web application for the Nueva Vizcaya Agricultural Terminal (NVAT) waste management system. This system tracks agricultural and plastic waste valorization through various processing technologies with AI-powered analytics.

## 🚀 Features

### 🤖 AI Analytics
- **Yield Prediction**: Machine learning models predict biogas, digestate, and larvae production based on waste characteristics
- **Image Recognition**: AI-powered image analysis for waste quality and contamination assessment using Grok API
- **Batch Scheduling**: AI-optimized processing schedules based on waste composition, weather, and demand patterns

### 📊 Dashboard
- Real-time statistics and KPIs
- Interactive charts and graphs (Chart.js)
- Weekly trends and output production tracking
- Process stream overviews

### 🔄 Processing Streams
- **Anaerobic Digestion**: Organic waste to biogas and digestate
- **BSF Larvae Cultivation**: Black Soldier Fly larvae processing
- **Activated Carbon Production**: Fruit seeds and hard waste conversion
- **Paper & Packaging Production**: Agricultural waste to packaging materials
- **Pyrolysis Operations**: Plastic waste to pyrolysis oil and syngas

### 📈 Management Features
- **Inventory Management**: Stock levels and adjustments
- **Sales & Revenue**: Sales tracking with Excel export
- **Energy Monitoring**: Energy consumption and cost tracking
- **Environmental Impact**: CO2 reduction and environmental metrics

### 📝 Data Entry
- **Waste Entries**: Comprehensive waste input tracking
- **Form Validation**: Server-side and client-side validation
- **Export Functionality**: Excel/CSV export capabilities

## 🛠️ Technology Stack

- **Backend**: Laravel 11
- **Frontend**: Blade Templates, Tailwind CSS
- **Charts**: Chart.js
- **Database**: MySQL/SQLite
- **AI Integration**: Grok API
- **Icons**: Font Awesome

## 📋 Requirements

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/SQLite
- Laravel 11

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Man18hash/WadhwaniB2-WasteNoMore.git
   cd WadhwaniB2-WasteNoMore
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database setup**
   ```bash
   php artisan migrate
   php artisan db:seed --class=WasteManagementSeeder
   php artisan db:seed --class=WeeklyStatsSeeder
   php artisan db:seed --class=BatchOutputSeeder
   php artisan db:seed --class=AIHistoricalDataSeeder
   ```

5. **Build assets**
   ```bash
   npm run build
   ```

6. **Start the server**
   ```bash
   php artisan serve
   ```

## 🗄️ Database Structure

### Core Tables
- `waste_entries` - Main waste input data
- `process_batches` - Processing batch tracking
- `batch_outputs` - Expected and actual outputs
- `weekly_statistics` - Weekly aggregated data
- `output_inventory` - Product inventory
- `sales_records` - Sales tracking
- `energy_consumption` - Energy usage monitoring
- `environmental_impact` - Environmental metrics

### Relationships
- ProcessBatch hasMany BatchOutput
- WasteEntry belongsTo ProcessBatch
- All models have proper foreign key relationships

## 🎯 Key Features

### AI Analytics Dashboard
- **Yield Prediction**: Predicts output quantities with confidence levels
- **Image Recognition**: Upload images for AI analysis of waste quality
- **Batch Scheduling**: AI recommendations for optimal processing times

### Processing Management
- **CRUD Operations**: Complete Create, Read, Update, Delete for all entities
- **Output Tracking**: Track expected vs actual outputs
- **Status Management**: Pending, Processing, Completed status tracking

### Data Visualization
- **Interactive Charts**: Line charts, bar charts, pie charts
- **Real-time Updates**: Dashboard refreshes with latest data
- **Export Capabilities**: Excel/CSV export for all data

### Form Validation
- **Server-side Validation**: Laravel Form Request classes
- **Client-side Validation**: JavaScript validation
- **Custom Rules**: Business logic validation rules

## 🔧 Configuration

### AI Integration
The system integrates with Grok API for image recognition. Configure your API key in the quality assessment view:
```javascript
const GROK_API_KEY = 'your-grok-api-key';
```

### Database Configuration
Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=waste-no-more
DB_USERNAME=your-username
DB_PASSWORD=your-password
```

## 📱 Usage

### Dashboard
Access the main dashboard at `/dashboard` to view:
- Weekly statistics
- Process stream overviews
- Recent activities
- Quick stats

### AI Analytics
Navigate to `/ai-analytics` for:
- Yield prediction with interactive charts
- Image recognition for waste quality assessment
- AI-powered batch scheduling recommendations

### Data Entry
Use the sidebar navigation to access:
- Waste Entries (`/waste-entries`)
- Processing Streams (Anaerobic Digestion, BSF Larvae, etc.)
- Management (Inventory, Sales, Energy, Environmental Impact)

## 🎨 Design Features

- **Responsive Design**: Mobile-friendly interface
- **Modern UI**: Clean, card-based layout
- **Color-coded Status**: Visual indicators for different states
- **Interactive Elements**: Hover effects and smooth transitions
- **Gradient Themes**: Purple/blue gradient color scheme

## 📊 Sample Data

The system includes comprehensive sample data:
- 11 waste entries
- 14 process batches (12 completed)
- 26 batch outputs
- 4 weekly statistics records
- 5 inventory items
- Historical data for AI predictions

## 🔒 Security Features

- **CSRF Protection**: All forms protected
- **Form Validation**: Server-side validation
- **SQL Injection Prevention**: Eloquent ORM
- **XSS Protection**: Blade template escaping

## 🚀 Deployment

1. **Production Environment**
   ```bash
   composer install --optimize-autoloader --no-dev
   npm run production
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Web Server Configuration**
   - Point document root to `public/` directory
   - Configure URL rewriting for Laravel
   - Set proper file permissions

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## 📄 License

This project is part of the Wadhwani Foundation competition.

## 🏆 Competition Features

This system was developed for the Wadhwani Foundation competition and includes:
- **AI Integration**: Advanced machine learning capabilities
- **Real-time Analytics**: Live data processing and visualization
- **Comprehensive Management**: Complete waste management workflow
- **Modern Technology**: Latest Laravel and frontend technologies
- **Scalable Architecture**: Ready for production deployment

## 📞 Support

For support or questions, please contact the development team.

---

**WASTE NO MORE** - Transforming waste into valuable resources through technology and innovation! 🌱♻️