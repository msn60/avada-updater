# Avada Manual Updater

* Contributors: [Mehdi Soltani](https://github.com/msn60)



## Description
It's a script to update Avada theme after finishing 6 month which you have bought it.


## FAQs

### 1- What is this script? Why do I need to use it?

> The reason of writing this scripts is related to solve automatic update problem after 6 month of buying Avada theme: 

For several years, we have decided to use Avada theme for many of our projects which is powered by WordPress. 
We always buy it from themeforest for each of our projects. 

> When you want to buy it, they say that you get theme update and related things to it forever.

At first, it's updated automatically from its repository. It was enough to update it from WordPress admin panel only.
But after finishing 6 month support, unfortunately you can not update it automatically from  WordPress admin panel.

Avada team, put new version of theme files in your themeforest account and also put related plugins like fusion core and fusion builder, inside your account in Avada site.

So you must download each of them and update it manually. 
you must consider that maybe you have specific language files (like .mo & .po) for each of them.
Also before any action or any update, you need to backup from older files or completely from your site files (it depends on you).
 
> It is easy to update Avada theme manually forever but what will happen if you have dozens of sites which is powered by Avada???

And this was the problem that I decided to write this script. 
Every time that Avada released new version, I had to updated Avada in dozens of our sites which have used Avada.
Due to having no option to update it automatically, so I had to write an script to handle this time consuming process. 

### 2- Who do you use it?

> If you buy Avada theme and you can not update automatically after first 6 month, you can use this script.


### 3- What process does this script do?

> These are in the following

1. Set initial configuration due to server response time
2. Check needed files and directory to run the script
3. Create log file to track every steps
4. Check for updraft backup and temporary move them
5. Backup from whole site files with zipping them
6. Backup from site database
7. Archive older version of Avada theme file, fusion builder and fusion core
8. Backup from language files
9. Update Avada theme and related dependencies
10. Update all of language file in Avada child them and fusion core and fusion builder

### 4- How can I run this script?

> These section will complete in the future


## License
> You can use this script for free.

## ChangeLog
1. version 1.1: Write procedural script to do update process
2. version 1.2: Change the structure of script to OOP and use from composer

* Find other services and products in our site: [وبمستر وردپرس](https://wpwebmaster.ir/)