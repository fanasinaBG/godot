extends CharacterBody2D

@onready var sprite = $AnimatedSprite2D
@onready var message_label = $Label
@onready var inventory_control = $InventoryIngredient
@onready var player_hands = $Sprite



const SPEED = 300
var haut = true
var bas = false
var gauche = false
var droite = false
var inventory_visible = false
#var last_collider_position: Vector2
var object_in_hands = null

var interaction_range_min = 400  # Distance minimale pour interagir
var interaction_range_max = 450  # Distance maximale pour interagir
var last_collider_position = null  # Position de la dernière collision
var message_text = ""  # Message dynamique

func _ready():
	inventory_control.visible = false
	message_label.visible = false
	player_hands.texture = null


func _process(_delta: float) -> void:
	var direction = Vector2.ZERO

	if Input.is_action_pressed("ui_up"):
		direction.y -= 1
		if !Input.is_action_pressed("ui_right") && !Input.is_action_pressed("ui_left"):
			sprite.play("run1")
		haut = true
		bas = false
		gauche = false
		droite = false

	if Input.is_action_pressed("ui_down"):
		direction.y += 1
		if !Input.is_action_pressed("ui_right") && !Input.is_action_pressed("ui_left"):
			sprite.play("run2")
		haut = false
		bas = true
		gauche = false
		droite = false

	if Input.is_action_pressed("ui_left"):
		direction.x -= 1
		if Input.is_action_pressed("ui_down"):
			sprite.play("run5")
		elif Input.is_action_pressed("ui_up"):
			sprite.play("run6")
		else:
			sprite.play("run4")
		haut = false
		bas = false
		gauche = true
		droite = false

	if Input.is_action_pressed("ui_right"):
		direction.x += 1
		if Input.is_action_pressed("ui_down"):
			sprite.play("run7")
		elif Input.is_action_pressed("ui_up"):
			sprite.play("run8")
		else:
			sprite.play("run3")
		haut = false
		bas = false
		gauche = false
		droite = true

	direction = direction.normalized()
	self.velocity = direction * SPEED

	if direction == Vector2.ZERO:
		if haut:
			sprite.play("idle")
		elif bas:
			sprite.play("idle1")
		elif gauche:
			sprite.play("idle3")
		elif droite:
			sprite.play("idle2")

	# Déplacement avec détection de collisions
	var collision = move_and_collide(self.velocity * _delta)
	if collision:
		var collider = collision.get_collider()
		if collider is StaticBody2D:
			# Vérifier la collision et ajuster le message
			if collider.name == "frigocoll":
				message_text = "Veuillez cliquer sur 'E'
				pour prendre un ingredient"
			elif collider.name == "vilany1":
				message_text = "Veuillez cliquer sur 'E'
				pour laisser verser l'ingredient
				dans vilany 1"
			elif collider.name == "vilany2":
				message_text = "Veuillez cliquer sur 'E'
				pour laisser verser l'ingredient
				dans vilany 2"
			elif collider.name == "vilany3":
				message_text = "Veuillez cliquer sur 'E'
				pour laisser verser l'ingredient
				dans vilany 3"
			else:
				message_text = ""  # Si aucune collision avec un nom valide

			# Afficher le message si un nom valide est trouvé
			if message_text != "":
				message_label.visible = true
				message_label.text = message_text
				last_collider_position = collider.global_position
			else:
				message_label.visible = false
	else:
		# Si il n'y a pas de collision, vérifier la distance
		if last_collider_position:
			# Calcul de la distance entre la position actuelle du joueur et la dernière position du collider
			var distance = global_position.distance_to(last_collider_position)

			# Vérification que la distance est dans les bonnes limites
			if distance < interaction_range_min or distance > interaction_range_max:
				# Si la distance est hors de la plage, on cache le message et l'inventaire
				message_label.visible = false
				inventory_control.visible = false
				inventory_visible = false
				message_label.text = ""
			else:
				if Input.is_action_just_pressed("E"):  # Vérifie si 'E' est pressée
					toggle_inventory()
		
func toggle_inventory():
	inventory_visible = not inventory_visible
	inventory_control.visible = inventory_visible

func update_hands(icon_texture: Texture):
	# Fonction qui permet de mettre à jour l'icône dans les mains du joueur
	player_hands.texture = icon_texture
