
## Commands

1. Create Laravel Project with Composer: 
    - `composer create-project laravel/laravel <name-of-app>`


2. Spin up local server: 
    - `php artisan serve`

3. Controller
    - `php artisan make:controller ExampleController`

4. Database Migrations
    - Run migration files: 
        - `php artisan migrate`
    - Fresh command ONLY when empty DB tables
        - This drops EVERY table in the DB, starts fresh, so you can edit the original migration file with your changes. 
        - `php artisan migrate:fresh`
    - Modify table **WHEN YOU HAVE DATA** - create new migration file
        - `php artisan make:migration add_favorite_column_to_users`
        - After set up new migration file execute with _php artisan migrate_
    - Later, add isAdmin column to Users table: 
        - `php artisan make:migration add_isadmin_column_to_users_table --table=users`
            - the `--table=users` flag adds some boiler plate in the migration file for us.

5. Set up NEW migration file for a new table: 
    - `php artisan make:migration create_posts_table`
        - _execute migration file with_ `php artisan migrate`

6. Set up NEW model with: 
     - `php artisan make:model Post`
        - _He used singular for both Controller and Model_

7. Set up your own custom **Middleware** with this command: 
    - `php artisan make:middleware MustBeLoggedIn`
        - Add your code. 
        - Add to `/Http/Kernel.php`, towards the botttom, as described around [(12:15)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400816#overview)
        - 

8. Create a Laravel Policy with command: 
    - `php artisan make:policy PostPolicy --model=Post`

---

---

## Resources

1. [Project Repo Here](https://github.com/LearnWebCode/laravel-course)

2.  Markdown. [Best Markdown Cheatsheet](https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet)

---


## Components instead of include() - Part 1
- Starts [(11:50)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34130780#content)

1. Create folder **components** in `/views` directory. Name matters. 
2. Create `views/components/layout.blade.php` (_file name not matter_).
3. Add Header code
4. Add `{{$slot}}` to display dynamic content
5. Add Footer Code
6. Add to `homepage.blade.php` with this syntax: 

```php
//Instead of include
@include('header')

//Use x
<x-layout>
    //Place view content here to display in our $slot
</x-layout>

```

## Components instead of include() - Part 2: **NESTED `components/` x-layouts**.

- We revist the use of components to cut down on duplicate views in [video #41 around (3:15)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview) 

- Recap: 
    - **MOVE** the `profile-posts.blade.php` view where user can see their posts, followers, following. (view which loads when user clicks their icon) to our **2nd component, `components/profile.blade.php`**

    - Instead move all of the code into our second layout in `views/components/profile.blade.php` so we can reuse it for each tab, **(1) Posts, (2) Followers, (3) Following**. 

    - Then back in `views/profile-posts.blade.php`, strip out only the code which displays the default code for user's own posts and **wrap that code around our 2nd layout x tags**
        - `<x-profile> </x-profile>`

- Now in our `views/profile-posts.blade.php` (_Nested layout_, **x-layout => x-profile**), we will initially have trouble accessing some of our values. 

- The solution is **similar to React's Props**

```php
//pass the values to our nested /components/layouts with "props":
  <x-profile :avatar="$avatar"> //add in whenever we complete the avatar section/

  </x-profile>

// updated DCT view: 
  <x-profile :username="$username" :currentlyFollowing="$currentlyFollowing"
  :postCount="$postCount">

  </x-profile>

//UPDATE: At () of 
// We use a single private function to return the $username, $currentlyFollowing and $postCount for
// the other two tabs using functions profileFollowing and profileFollowers which returns the three
// variables above in an array called '$sharedData' so we HAVE to update our Props or else we'll get an error
// So this: 
<x-profile :username="$username" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount">
// Simply becomes: 
<x-profile :sharedData="$sharedData">

```

#### Setting up Tabs (_followers_ and _following_)
- [Set up the routes for followers and following tabs (~7:44)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503222#overview)
    
    - See the `Profile Related Routes` section of web.php (_Controlled by `UserController.php`_)
    - Duplicate the `profile()` function in `UserController.php` but rename `profileFollowing()` and `profileFollowers()` and return new blade templates for each (_profile-following_ and _profile_followers_).
        - Copy and paste the stripped out template we are using for our original **profile-posts.blade.php** template, utilizing our *new x-profile nested layout*.
    - **Video 41 - (9:55) - Update href values for each tab**, which is now in **/components/profile.blade.php**. 

- **Video 42** - [starts with the css effects to show a tab is **active**](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503226#overview)

    - setup ternary operator in `{{ }}` to handle which href tab is active.
    - use new **Request::segment(3)** which pertains to each '/' after base domain. 
        - Using our setup, when a tab is active, it **HAS** a _third segment_, ie: `/(1)profile/(2)username/(3)following`
        - 
- **Video 43** - [Set up relationship in User.php for followers()](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503228#notes)
    - Around 6th minute, test the json returned by calling our `followers()` function set up in `User.php` via the `UserController => followers()` function:

```js
//The followers of Brad (Barksalot and Meowsalot)
[{"id":3,"user_id":2,"followeduser":1,"created_at":"2024-01-18T00:39:26.000000Z","updated_at":"2024-01-18T00:39:26.000000Z"},
{"id":2,"user_id":3,"followeduser":1,"created_at":"2024-01-18T00:34:07.000000Z","updated_at":"2024-01-18T00:34:07.000000Z"}]
```


### Private functions in Controllers (_in this case, to handle duplicate code_)
- See [(3:28)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34503226#notes)
    - Applied to `profile()`, `profileFollowing()` and `profileFollowers()` functions in `UserController`.

    - In the **private** function which handles our duplicate code, we will use Laravel's facade, **View::share()**
        - Format: `View::share('label', 'variable or array of variables to share')`
        - x


---

### Laravel Sessions
- Click 'inspect' => dev tools => 'Application' => 'Cookies' => site
    - see `laravel_session`
- Display logged in user's name with `{{auth()->user()->username}}`. See [(19:11)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207654#overview)

- 


### Useful Tips

- Save user input between attempts: 
    - use `value="{{old('field-name')}}`. See [(16:15)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34207648#overview)
    - 

- To look up user by field **other than id** simply specify in the routes like this: 

```php
// web.php
Route::get('/profile/{pizza:username}', [UserController::class, 'profile']);

// UserController.php - profile function:
    // GET INSTANCE OF USER with TYPE HINTING = User <{name-used-in-routes}>
    public function profile(User $pizza){
        //instance of the User model with type hinting

        return view('profile-posts');
    }

```



---

## **Middleware**
- 
    - Protect pages - Unauthorized Redirect: 
    - Instead of using `!auth()->check()` like below

```php
    public function showCreateForm(){
        //(~1:30) - Add redirect if /create-post accessed by guest: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351476#overview

        if (!auth()->check()) {
            return redirect('/');
        } 
        return view('create-post');
    }

```

### Named Routes (**Zef used for admin routes**)
- _I believe this was covered in Video #25, around minute 1:30?_. [Check link](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351476#overview)

- In the `web.php` routes file add middleware with: 

```php

//Add ->middleware('auth') 
Route:: get('/create-post', [PostController::class, 'showCreateForm'])->middleware('auth');

//This requires us to 'name' one of our other routes as 'login' for laravel to send the redirect
```


---
### Policy
- See [(~4:00)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview)

- Create a policy from terminal with command: 
    - `php artisan make:policy PostPolicy --model=Post`

- Laravel's Policy allows us to avoid having to do things like check if the currently logged in user is the user of the a given post: 

```php

//PostController.php
    public function viewSinglePost(Post $post){
        if($post->user_id === auth()->user()->id){
            return 'you are the author';
        }
        return 'you are not the author;
    }

```

- Update the Policies you want to control, _in this example, edit and delete_ in the new folder `Http/Policies/PostPolicy.php`

```php

    public function update(User $user, Post $post): bool
    {
        // (~7:00): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview
        return $user->id === $post->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        // (~7:00): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview
        return $user->id === $post->user_id;
    }
```

- Finally, register our new **PostPolicy.php** in `App/Providers/AuthServiceProviders.php` in the `protected $policies` array, let Laravel know what class our new custom policy should be applied to: 

```php
// Added (7:55): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview
    
    protected $policies = [
        Post::class => PostPolicy::class
    ];

```


```php

// Added (7:55): https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426438#overview
    protected $policies = [
        Post::class => PostPolicy::class
    ];
```

---

## Install MySQL on Windows
[View tutorial here](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34182370#content)

1. Visit [mysql.com](https://www.mysql.com/) and follow google doc instructions. 

---
 
## Connect Local Laravel to Local MySQL - **migrations**
- **Source:** [See tutorial here.](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34197742#content)

1. Connect to DB in `.env` file

```js
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ourlaravelapp
DB_USERNAME=root
DB_PASSWORD=rootroot

```

2. in the **migrations** directory we have the default migrations from Laravel. 

3. Run the migrate command from terminal in project directory to create the default tables laravel has created for us: 
    - `php artisan migrate`


4. Recap Creating a local MySQL database at [Video 18. (6:30)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34182370#overview)
    - Recap of the laravel migrations at [Video 20. (~6:30)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34197742#overview)
    - x

---


## Set up Notes (Posts) Database 
- Started [Video 25. (9:30)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351476#overview)

- Set up migration file for posts db with command: 
    - `php artisan make:migration create_posts_table`

    - See around [Video 25. (13:00)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351476#overview) to see how the migration file was set up between `users` and `posts`

    - Run the migration file with: 
        - `php artisan migrate`

```php
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->longText('body');
            $table->foreignId('user_id')->constrained();
        });
    }

```

- Set up model for Posts with this command: 
    - He used **singular Post**
    - `php artisan make:model Post`


### Set up foreign key relationship in **Post.php** model to User
- See [Video 27. (1:20)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview)

- Add the relationship b/t Post and User (`belongsTo`) in **Post.php**

```php
//Post.php
    //(1:40) - Set relationship to User: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34351482#overview
    // public function user(){
    public function pizza(){
        //this is Post object as a whole
        // look inside '$this' and call method 'belongs to'
                        //(1) Class belongs to, (2) Column powered by. Column powers the lookup or join. 
        return $this->belongsTo(User::class, 'user_id');
    }

```
### Set up User-Post relationship in **User.php** model: 
- This was covered around [(8:55)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview)

- Here is the **User.php** function we added: 

```php
//User.php
// Added (~9:38) - https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34400818#overview
    public function posts() {
        //A user Has MANY posts:
        // hasMany(target class, column powering this relationship)
        return $this->hasMany(Post::class, 'user_id');
    }

//Then use new relationship in UserController.php: 


```
-- **This will now return the following:**

```json
[
    {"id":1,"created_at":"2024-01-16T22:28:53.000000Z","updated_at":"2024-01-16T22:28:53.000000Z","title":"My First Post","body":"The sky is blue.","user_id":1},

    {"id":2,"created_at":"2024-01-16T22:36:22.000000Z","updated_at":"2024-01-16T22:36:22.000000Z","title":"My Second Blog Post","body":"Did you know that 2 + 2 is 4?","user_id":1},
    
    {"id":3,"created_at":"2024-01-16T23:52:37.000000Z","updated_at":"2024-01-16T23:52:37.000000Z","title":"My Third Post","body":"This is a test.","user_id":1},
    
    {"id":4,"created_at":"2024-01-17T00:03:42.000000Z","updated_at":"2024-01-17T00:03:42.000000Z","title":"Quick Test Post","body":"# My heading\r\n\r\nMake something **bold** or *italics*.","user_id":1}
    ]
```


#### Run Migration To Add Table to Users Table
- See [(3:15)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426448#overview)

- To set up the [migration file to add a column to existing table at (3:30)](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426448#overview), run command: 
    `php artisan make:migration add_isadmin_column_to_users_table --table=users`




---


### Set up a 'Gate' in Laravel 

- See [tutorial here.](https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426458#overview)

- Set up route in `web.php`

- In `app/Providers/AuthServiceProvider.php` edit the **boot()** function: 

```php

// (5:20) Must uncomment reference to Gate provided by laravel: https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426458#overview
use Illuminate\Support\Facades\Gate;
// (3:30) - set up 'Gate': https://www.udemy.com/course/lets-learn-laravel-a-guided-path-for-beginners/learn/lecture/34426458#overview
    // public function boot(): void //OUR version had void
    public function boot() 
    {
        //our version missing '$this->registerPolicies();
        $this->registerPolicies();

        //spell out our gate: 
        // Gate::define('label', function)
        Gate::define('visitAdminPages', function($user){
            return $user->isAdmin === 1;
        });
    }

//Then in web.php (or controller) use our gate as follows: 
Route::get('/admins-only', function(){
    //Set normal controller and functions here.
    if (Gate::allows('visitAdminPages')) {
        //restricted content here.
        return 'Only admins should be able to see this page';
    }
    return 'You can not view this page.';
});

```


### Push Local Laravel to Github
1. **Create Github Repo** - However, do not initialize it with a README or .gitignore at this point.
2. **Initialize Repo** - In Laravel project directory check if there is a Git repository with 
    - `git status`
    - If this fails, not a git repository then initialize one with the ole' 
        - `git init`

3. **Set Remote URL**
4. **Add changes and commit**
5. **Push up to the remote**


### Copy Project to another directory

1. Copy files Locally (do not manually create the new desired directory, specify in command `newProject`)
    - `cp -r path/to/myApp path/to/newProject`

### Copy Project to another directory on another computer
1. Clone the repository
    - `git clone https://github.com/your_username/myApp.git`

2. Copy Files to new directory 'newProject'
    - `cp -r myApp path/to/newProject`

3. Navigate to 'newProject' Directory
    - `cd path/to/newProject`

4. **CHANGE REMOTE URL** - point the 'newProject' to the new clean repo: 
    `git remote set-url origin https://github.com/your_username/newProjectRepo.git`

5. Make changes and Push: 
    ```js
    git add .
    git commit -m "Your commit message"
    git push -u origin master
    ```
6. _There should not be any conflict between the two projects as long as you are working in separate directories ('myApp' and 'newProject'). Each project will have its own Git repository, and changes made in one project will not affect the other._

7. _When you copy files from 'path/to/myApp' to 'path/to/newProject', you are essentially duplicating the project directory. The initialized Git repository (the .git directory) is part of the project structure, and it will be copied along with the files. As a result, the new directory ('newProject') will still be associated with the same Git repository as the original ('myApp')._
    - **You can confirm this by checking if the 'newProject' directory contains '.git' directory with this command to attempt to ls the '.git' repository:**
    - 
    - `ls path/to/newProject/.git`
        ```js
        $ ls ourmainapp/.git
        COMMIT_EDITMSG  config       hooks/  info/  objects/
        HEAD            description  index   logs/  refs/

        ```
    - If no git repository exists, expect a result like: 
        ```js
        $ ls dent/.git
        ls: cannot access 'dent/.git': No such file or directory

        ```
    - To remove multiple non-empty directories, use: 
        - `rm -r directory1 directory2 directory3`
    - To remove an empty directory use: 
        `rmdir directory_name`
    - **(Optional):** _Confirming Deletion_ vs _Force Removal_
        - _If you want to be prompted for confirmation before each removal, you can use the `-i` (interactive) flag:_
            `rm -ri directory_name`
        - _If you want to force removal without any confirmation, you can use the `-f` (force) flag:_
            - `rm -rf directory_name`
    - x
`

---

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
