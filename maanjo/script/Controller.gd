extends Node

@onready var player = get_node("..")
@onready var inventory_ingredient = player.get_node("InventoryIngredient")  # Accès via le parent
@onready var button_container = inventory_ingredient.get_node("ButtonContainer")  # Conteneur des boutons
var buttons = []

func _ready():
	# Vérification de l'existence du conteneur de boutons
	if button_container:
		# Connexion des boutons dans InventoryIngredient
		for i in range(1, 11):  # On suppose qu'il y a 10 boutons
			var button_name = "Button" + str(i)
			var button = button_container.get_node(button_name)
			if button:
				buttons.append(button)
				# Connexion du signal avec une fonction lambda correcte
				button.pressed.connect(_on_button_pressed.bind(button))  # Utilisation de .bind() ici
	else:
		print("Le conteneur de boutons n'a pas été trouvé.")

# Fonction appelée lorsque le bouton est pressé
func _on_button_pressed(button: Button) -> void:
	var icon_texture = button.icon  # Récupère l'icône du bouton pressé
	if icon_texture:
		# Mets à jour les mains du joueur avec l'icône du bouton
		player.update_hands(icon_texture) 
		 
		# Efface l'icône du bouton après l'avoir prise
		#button.icon = null  
		# Optionnel : Tu peux réinitialiser ou changer l'icône du bouton ici si nécessaire.
		# Ex : button.icon = some_new_icon
