## About Project

Simple Laravel application which have crud of Event using ajax and run event.
- frontend validation
- backend validation
- bootstrap theme
- ajax crud on single page.
- on edit only title is editable.
- scheduler to run command event daily,weekly,monthly,yearly events.

### requirement
- php8
- composer

### Event Details
- Title 
- Start Date
- End Date or Num of Occurrence
  - Event will stop executing until enddate reached or number of time executed (Num of Occurrence) 
- Repeat On : Day,Week,Month,Year
  - Day
    - will run daily
  - week : Monday,Tuesday,Wednesday,Thursday,Friday,Saturday.
    - it will run on selected week.
  - month: 1,2,3,4,6
    - every 1 month or 2 months or 3 months, etc..
  



### Steps to install
- clone repo
- composer install
- php artisan:migrate
  - will run the migration, please set up database name in your .env file to run migration.
- for test data,factory is created.
  ```
  App\Models\Event::factory()->withEndDateDaily()->count(10)->create();
  App\Models\Event::factory()->withEndAfterNumOfOccurenceDaily()->count(10)->create();
  
  App\Models\Event::factory()->withEndDateMonthly()->count(10)->create();
  App\Models\Event::factory()->withEndAfterNumOfOccurenceMonthly()->count(10)->create();
  
  App\Models\Event::factory()->withEndDateWeekly()->count(10)->create();
  App\Models\Event::factory()->withEndDateYearly()->count(10)->create();
  
  App\Models\Event::factory()->withEndAfterNumOfOccurenceWeekly()->count(10)->create();
  App\Models\Event::factory()->withEndAfterNumOfOccurenceYearly()->count(10)->create();
  ```
- set up cron tab to execute command
  ```
  * * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1
  OR
  * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
  ```

### How event call
- there are command created for daily,weekly,monthly,early and all are been called from schedule.
- daily
  - call daily
- weekly
  - call daily and get current day and run.
- monthly
  - call on every month
- yearly
  - call on every year
- until event table fields end_after_occurrences not equal to successfullyRunCount or end date reach
