require 'compass/import-once/activate'
add_import_path "bower_components/foundation/scss"
# Require any additional compass plugins here.

http_path = "/"
css_dir = "css"
sass_dir = "css/sass"
images_dir = "images"
javascripts_dir = "js"

# You can select your preferred output style here (can be overridden via the command line):
# output_style = :expanded or :nested or :compact or :compressed
output_style = :compressed

# To enable relative paths to assets via compass helper functions. Uncomment:
relative_assets = true

# To disable debugging comments that display the original location of your selectors. Uncomment:
# line_comments = false


# If you prefer the indented syntax, you might want to regenerate this
# project again passing --syntax sass, or you can uncomment this:
# preferred_syntax = :sass
# and then run:
# sass-convert -R --from scss --to sass sass scss && rm -rf sass && mv scss sass

require 'autoprefixer-rails'
on_stylesheet_saved do |file|
    css = File.read(file)
    File.open(file, 'w') do |io|
        io << AutoprefixerRails.process(css)
    end
end

require 'fileutils'
on_stylesheet_saved do |file|
    if File.exists?(file) && File.basename(file) == "style.css"
        puts "Moving: #{file}"
        FileUtils.mv(file, File.dirname(file) + "/../" + File.basename(file))
    end
end