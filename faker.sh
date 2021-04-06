counter=1
until [ $counter -gt 2 ]
do
	casestudy_id=$(wp post generate --post_type=casestudy --count=1 --post_title="Cas d'étude ${counter}" --format=ids)
	wp media import 'https://picsum.photos/600/400.jpg' --post_id=$casestudy_id --title="Image for Product ${counter}" --featured_image
	wp post meta set $casestudy_id _price $random_price
	counter=$(($counter + 1))
done